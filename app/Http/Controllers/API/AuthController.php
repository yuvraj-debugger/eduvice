<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\HighSchool;
use App\Models\TestScore;
use App\Models\Preference;
use App\Models\UserDocument;
use App\Models\Message;
use App\Models\GlobalCourses;
use App\Models\MasterDegree;
use App\Models\GraduationDegree;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Models\Course;
use App\Models\University;
use Propaganistas\LaravelPhone\Rules\Phone;
use App\Models\CourseEstDetail;

class AuthController extends BaseController
{

    public function userVerify(Request $request)
    {
        $tokenCheck = User::where('remember_token', $request->token)->first();
        $token = $tokenCheck->remember_token;
        if (! $token) {
            return $this->sendError('Please check the link again', 'Invalid token!');
        }
        $userDate = User::where('remember_token', $token)->update([
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        return view('userVerify.usersuccess');
    }

    public function signin(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if(!empty($user)&&$user->status==2)
        {
            return $this->sendError('User does not exist', [
                'error' => 'User is deleted.'
            ]);
        }
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'Login Successfully');
            // if(!empty($authUser->email_verified_at))
            // {
            // $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            // $success['name'] = $authUser->name;

            // return $this->sendResponse($success, 'Login Successfully');
            // }
            // else
            // {
            // return $this->sendError('Verify your email', [
            // 'error' => 'Verify your email'
            // ]);
            // }
        } else {
            return $this->sendError('Invalid credentials, please verify them and retry.', [
                'error' => 'Invalid credentials, please verify them and retry.'
            ]);
        }
    }

    public function signemail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            Auth::loginUsingId($user->id);
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] = $authUser->name;
            return $this->sendResponse($success, 'Login Successfully');
        } else {
            return $this->sendError('Invalid credentials, please verify them and retry.', [
                'error' => 'Invalid credentials, please verify them and retry.'
            ]);
        }
    }

    public function accountSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_sms' => 'required|in:0,1',
            'is_mail' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->messages()
                ->all());
        }
        $userSetting = User::find(Auth::user()->id);
        $userSetting->is_sms = $request->is_sms;
        $userSetting->is_mail = $request->is_mail;
        $userSetting->update();
        $success['detail'] = user::where('id', Auth::user()->id)->first();
        return $this->sendResponse($success, 'Account Settings Updated Successfully. ');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'date_of_birth' => 'required|before: 5 years ago',
            'gender' => 'required|in:male,female,transgender',
            'martial_status' => 'required|in:married,unmarried',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'pincode' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:3',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $country=Country::where('name',$request->country)->first();
        if(!empty($country))
        {
            
            $validator = Validator::make($request->all(), [            
                'contact' => 'required|phone:'.$country->shortname
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['remember_token'] = uniqid();
            $user = User::create($input);

            $userData = User::where('id', $user->id)->first();
            $team = TeamUser::create([
                'team_id' => 1,
                'user_id' => $user->id,
                'role' => 'student'
            ]);

            Mail::send('email.userRegister', [
                'token' => $input['remember_token'],
                'email' => $request->email
            ], function ($userData) use ($request) {
                $userData->to($request->email);
                $userData->subject('Verify Email Address');
            });

            $success['token'] = $user->createToken('MyAuthApp')->plainTextToken;
            $success['name'] = $user->name;
            $success['message'] = 'Verify your email address';

            return $this->sendResponse($success, 'User created successfully.');
        }
        else
        {
            return $this->sendError('Error validation', 'Country is invalid');
        }
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required|before: 5 years ago',
            'passport_number' => 'required',
            'martial_status' => 'required|in:married,unmarried',
            'gender' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $country=Country::where('name',$request->country)->first();
        if(!empty($country))
        {
            
            $validator = Validator::make($request->all(), [            
                'contact' => 'required|phone:'.$country->shortname
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }

            $userProfile = User::find(Auth::user()->id);
            $userProfile->name = $request->name;
            $userProfile->email = $request->email;
            $userProfile->date_of_birth = $request->date_of_birth;
            $userProfile->passport_number = $request->passport_number;
            $userProfile->martial_status = $request->martial_status;
            $userProfile->gender = $request->gender;
            $userProfile->contact = $request->contact;
            $userProfile->address = $request->address;
            $userProfile->country = $request->country;
            $userProfile->country_code = $request->country_code;
            $userProfile->state = $request->state;
            $userProfile->city = $request->city;
            $userProfile->pincode = $request->pincode;
            $userProfile->update();

            $success['detail'] = user::where('id', Auth::user()->id)->first();
            return $this->sendResponse($success, 'User Details Updated Successfully.');
        }
        else
        {
            return $this->sendError('Error validation', 'Country is invalid');
        }
    }

    public function userDetails()
    {
        $userId = Auth::user()->id;
        $userData = User::with('getEducation')->with('getScore')
            ->with('getPreference')
            ->with('getDocument')
            ->where('id', $userId)
            ->first();

        $success = $userData;
        return $this->sendResponse($success, 'User Details');
    }

    public function preferenceDetails()
    {
        $success = Preference::all();
        return $this->sendResponse($success, 'All Preference');
    }

    public function addTestScore(Request $request)
    {
        if (empty($request->test_type)) {
            $validator = Validator::make($request->all(), [
                'test_score' => 'required',
                'overall' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }
            $testScore = TestScore::create([
                'test_score' => $request->test_score,
                'overall' => $request->overall,
                'remarks' => $request->remarks,
                'created_by' => Auth::user()->id
            ]);
            return $this->sendResponse('success', 'Test Score created successfully.');
        } else {
            $user = User::find(Auth::user()->id);
            $user->type = $request->test_type;
            $user->update();
            return $this->sendResponse('success', 'Test Score updated Successfully');
        }
    }

    public function addEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required',
            'mark_grade' => 'required',
            'passing_year' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $educationDetails = HighSchool::where('type', $request->type)->first();
        if (! empty($educationDetails)) {
            $educationDetails->class = ! empty($request->class) ? $request->class : '';
            $educationDetails->mark_grade = ! empty($request->mark_grade) ? $request->mark_grade : '';
            $educationDetails->passing_year = ! empty($request->passing_year) ? $request->passing_year : '';
            $educationDetails->institution = ! empty($request->institution) ? $request->institution : '';
            $educationDetails->update();
            $success['detail'] = HighSchool::where('type', $request->type)->first();
            return $this->sendResponse($success, 'Education updated successfully.');
        } else {
            $highSchool = HighSchool::create([
                'class' => $request->class,
                'mark_grade' => $request->mark_grade,
                'passing_year' => $request->passing_year,
                'institution' => $request->institution,
                'type' => $request->type,
                'created_by' => Auth::user()->id
            ]);
            $success['detail'] = HighSchool::where('type', $request->type)->first();
            return $this->sendResponse($success, 'Education created successfully.');
        }
    }

    public function updateAllEducation(Request $request)
    {
        if (! empty($request->class)) {
            $validator = Validator::make($request->all(), [
                'class' => 'required',
                'mark_grade' => 'required',
                'passing_year' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }

            HighSchool::updateOrCreate([
                'created_by' => Auth::user()->id,
                'type' => 1
            ], [
                'class' => $request->class,
                'mark_grade' => $request->mark_grade,
                'passing_year' => $request->passing_year,
                'institution' => $request->institution
            ]);
        }

        if (! empty($request->graduation)) {
            $validator = Validator::make($request->all(), [
                'graduation' => 'required',
                'graduation_mark_grade' => 'required',
                'graduation_passing_year' => 'required',
                'graduation_institution' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }

            HighSchool::updateOrCreate([
                'created_by' => Auth::user()->id,
                'type' => 2
            ], [
                'class' => $request->graduation,
                'mark_grade' => $request->graduation_mark_grade,
                'passing_year' => $request->graduation_passing_year,
                'institution' => $request->graduation_institution
            ]);
        }

        if (! empty($request->master)) {
            $validator = Validator::make($request->all(), [
                'master' => 'required',
                'master_mark_grade' => 'required',
                'master_passing_year' => 'required',
                'master_institution' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }
            HighSchool::updateOrCreate([
                'created_by' => Auth::user()->id,
                'type' => 3
            ], [
                'class' => $request->master,
                'mark_grade' => $request->master_mark_grade,
                'passing_year' => $request->master_passing_year,
                'institution' => $request->master_institution
            ]);
        }
        $success = HighSchool::where('created_by', Auth::user()->id)->get();
        return $this->sendResponse($success, 'Education Details Updated Successfully');
    }

    public function updateEducation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required',
            'mark_grade' => 'required',
            'passing_year' => 'required',
            'institution' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $educationDetails = HighSchool::where('id', $id)->first();
        if (! empty($educationDetails)) {
            $educationDetails->class = ! empty($request->class) ? $request->class : '';
            $educationDetails->mark_grade = ! empty($request->mark_grade) ? $request->mark_grade : '';
            $educationDetails->passing_year = ! empty($request->passing_year) ? $request->passing_year : '';
            $educationDetails->institution = ! empty($request->institution) ? $request->institution : '';
            $educationDetails->update();
            $success['detail'] = HighSchool::where('id', $id)->first();
            return $this->sendResponse($success, 'Education updated successfully.');
        } else {
            return $this->sendError('Error data not found', "Education detail is empty");
        }
    }

    public function updateTestScore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|numeric|in:1,2'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $testScore = TestScore::where('created_by', Auth::user()->id)->first();
        if (! empty($testScore)) {
            $testScoreDelete = $testScore->delete();
        }
        $user = User::find(Auth::user()->id);
        $user->type = $request->type;
        $user->remarks = $request->remarks;
        $user->update();
        return $this->sendResponse('success', 'Test Score Updated Successfully');
    }

    public function updatePreference(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_of_interest' => 'required|integer|min:1',
            'preferred_course' => 'required',
            'preferred_budget_min' => 'required|min:1',
            'preferred_budget_max' => 'required|min:1',
            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        Preference::updateOrCreate([
            'created_by' => Auth::user()->id
        ], [
            'area_of_interest' => ! empty($request->area_of_interest) ? $request->area_of_interest : '',
            'country_id' => ! empty($request->country_id) ? $request->country_id : '',
            'preferred_course' => ! empty($request->preferred_course) ? $request->preferred_course : '',
            'preferred_budget_min' => ! empty($request->preferred_budget_min) ? $request->preferred_budget_min : '',
            'preferred_budget_max' => ! empty($request->preferred_budget_max) ? $request->preferred_budget_max : ''
        ]);
        return $this->sendResponse('Success', 'Preferences Updated Successfully.');
    }

    public function uploadDocument(Request $request)
    {
        $testScore = TestScore::where('created_by', Auth::user()->id)->first();
        if (! empty($testScore)) {
            if ($testScore->test_score == 'IELTS') {
                $validator = validator::make($request->all(), [
                    'english_test_doc' => 'required'
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Error validation', $validator->errors());
                }
            }
        }
        $course = Course::where('id', $request->course_id)->first();
        if (! empty($course) && $course->countryName != 'United Kingdom') {
            $validator = validator::make($request->all(), [
                'lor' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }
        }
        $validator = validator::make($request->all(), [
            'degree_doc' => 'required',
            'passport_doc' => 'required',
            'passport_number'=>'required',
            'sop'=>'required',
            'university_id'=>'required',
            'course_id'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $userDoc = new UserDocument();
        if (! empty($request->english_test_doc) || ! empty($request->degree_doc) || ! empty($request->cv_experienced_doc) || ! empty($request->passport_doc) || ! empty($request->lor)) {
            if (! empty($request->english_test_doc)) {
                $filenameWithExtension =  $request->english_test_doc->getClientOriginalName();
                $filenameWithoutExtension = pathinfo(basename($filenameWithExtension), PATHINFO_FILENAME);
                $fileExtension = pathinfo($filenameWithExtension, PATHINFO_EXTENSION);
                $engDoc = $filenameWithoutExtension.uniqid() .'.'.$fileExtension;
                $request->english_test_doc->storeAs('file_uploads', $engDoc, 'public');
                $userDoc->english_test_doc = $engDoc;
            }
            if (! empty($request->degree_doc)) {
                
                $filenameWithExtension =  $request->degree_doc->getClientOriginalName();
                $filenameWithoutExtension = pathinfo(basename($filenameWithExtension), PATHINFO_FILENAME);
                $fileExtension = pathinfo($filenameWithExtension, PATHINFO_EXTENSION);
                $degree_doc =$filenameWithoutExtension. uniqid() .'.'. $fileExtension;
                $request->degree_doc->storeAs('file_uploads', $degree_doc, 'public');
                $userDoc->degree_doc = $degree_doc;
            }
            if (! empty($request->cv_experienced_doc)) {
                $filenameWithExtension =  $request->cv_experienced_doc->getClientOriginalName();
                $filenameWithoutExtension = pathinfo(basename($filenameWithExtension), PATHINFO_FILENAME);
                $fileExtension = pathinfo($filenameWithExtension, PATHINFO_EXTENSION);
                $cvExperienced_doc = $filenameWithoutExtension.uniqid() .'.'. $fileExtension;
                $request->cv_experienced_doc->storeAs('file_uploads', $cvExperienced_doc, 'public');
                $userDoc->cv_experienced_doc = $cvExperienced_doc;
            }
            if (! empty($request->passport_doc)) {
                $filenameWithExtension =  $request->passport_doc->getClientOriginalName();
                $filenameWithoutExtension = pathinfo(basename($filenameWithExtension), PATHINFO_FILENAME);
                $fileExtension = pathinfo($filenameWithExtension, PATHINFO_EXTENSION);
                
                $passport_doc = $filenameWithoutExtension.uniqid().'.'.$fileExtension;
                $request->passport_doc->storeAs('file_uploads', $passport_doc, 'public');
                $userDoc->passport_doc = $passport_doc;
            }
            if (! empty($request->lor)) {
                $filenameWithExtension =  $request->lor->getClientOriginalName();
                $filenameWithoutExtension = pathinfo(basename($filenameWithExtension), PATHINFO_FILENAME);
                $fileExtension = pathinfo($filenameWithExtension, PATHINFO_EXTENSION);
                $lor_doc = $filenameWithoutExtension.uniqid().'.'.$fileExtension;
                $request->lor->storeAs('file_uploads', $lor_doc, 'public');
                $userDoc->lor = $lor_doc;
            }

            $userDoc->passport_number = $request->passport_number;
            $userDoc->sop = $request->sop;
            $userDoc->created_by = Auth::user()->id;
            $userDoc->university_id = $request->university_id;
            $userDoc->campus_id = $request->campus_id;
            $userDoc->course_id = $request->course_id;
            $userDoc->save();
        }
        return $this->sendResponse('success', 'User Document Upload successfully.');
    }

    public function uploadprofilephoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        if ($request->hasFile('profile_photo')) {
            $filename = $request->profile_photo->getClientOriginalName();
            $request->profile_photo->storeAs('profile-photos', $filename, 'public');

            $user = User::where('id', Auth::user()->id)->first();

            $user->profile_photo_path = 'profile-photos/' . $filename;
            $user->update();

            Auth::setUser($user);

            $success['detail'] = Auth::user();
            return $this->sendResponse($success, 'User profile photo updated successfully.');
        }
        return $this->sendError('Profile photo not found', 'Profile photo is not uploaded');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        if (! Hash::check($request->old_password, auth()->user()->password)) {
            return $this->sendError('success', [
                'password' => 'Old Password Doesn\'t match!'
            ]);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => bcrypt($request->new_password)
        ]);
        $success['password'] = 'Password Change';
        return $this->sendResponse($success, "Password Updated Successfully.");
    }

    public function logout(Request $request)
    {
        auth()->user()
            ->tokens()
            ->delete();
        $success['message'] = 'Logged Out';
        return $this->sendResponse($success, 'User logged out successfully.');
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $token = Str::random(64);
        $input = $request->all();
        $input['token'] = $token;
        $input['created_at'] = date('Y-m-d H:i:s');

        $passwordReset = PasswordReset::create($input);

        Mail::send('email.forgetPassword', [
            'token' => $token,
            'email' => $request->email
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        $success['email'] = $request->email;
        return $this->sendResponse($success, 'We have e-mailed your password reset link!');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'token' => 'required',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (! $updatePassword) {
            return $this->sendError('Please check the link again', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        PasswordReset::where([
            'email' => $request->email
        ])->delete();
        $success['email'] = $request->email;
        return $this->sendResponse($success, 'Your password has been changed!');
    }

    public function passwordMail(Request $request)
    {
        $tokenCheck = PasswordReset::where('token', $request->token)->first();
        $token = $tokenCheck->token;
        if (! $token) {
            return $this->sendError('Please check the link again', 'Invalid token!');
        }
        return view('resetpassword.password-change', [
            'token' => $token
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $token = PasswordReset::where('token', $request->token)->first();

        if (! $token) {
            return $this->sendError('Please check the link again', 'Invalid token!');
        }
        $userMail = User::where('email', $token->email)->update([
            'password' => Hash::make($request->confirm_password)
        ]);
        PasswordReset::where([
            'email' => $request->email
        ])->delete();
        if ($userMail) {
            return view('resetpassword.successful');
        } else {
            return redirect()->back();
        }
    }

    public function myApplication()
    {
        $userId = Auth::user()->id;
        $applicationNumber = UserDocument::with('getMessage')->with('getCourse')
            ->with('getUniversity')
            ->with('getCampus')
            ->where('created_by', $userId)
            ->get();
        $success['data'] = $applicationNumber;

        return $this->sendResponse($success, 'My application Data');
    }

    public function message(Request $request, $document_id)
    {
        if ($request->type == 1) {
            $validator = Validator::make($request->all(), [
                'message' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }
            $message = Message::create([
                'message' => $request->message,
                'type' => $request->type,
                'document_id' => $document_id,
                'url'=> $request->url,
                'created_by' => Auth::user()->id
            ]);
            return $this->sendResponse('Success', 'Message sent successfully.');
        } else if ($request->type == 2) {
            $validator = Validator::make($request->all(), [
                'message_document' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }
            $messageDoc = $request->message_document;
            $message = new Message();
            $messageDoc = $messageDoc->getClientOriginalName();
            $request->message_document->storeAs('message_document', $messageDoc, 'public');
            $message->message = '-';
            $message->message_document = $messageDoc;
            $message->document_id = $document_id;
            $message->type = 2;
            $message->created_by = Auth::user()->id;
            if (! $message->save()) {
                throw new \Exception("Data not saved");
            }
            return $this->sendResponse('Success', 'Message sent successfully.');
        } else {
            return $this->sendError('Error', 'Message sent Failed.');
        }
    }

    public function preferred_search(Request $request)
    {
        $search = $request['query'] ?? "";
        $global_search = GlobalCourses::where('title', 'like', "%$search%")->get();
        return $this->sendResponse($global_search, 'Global Search Data.');
    }

    public function addIelts(Request $request)
    {
        if (empty($request->type)) {
            $validator = Validator::make($request->all(), [
                'overall' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error validation', $validator->errors());
            }

            TestScore::updateOrCreate([
                'created_by' => Auth::user()->id
            ], [
                'test_score' => 'IELTS',
                'overall' => $request->overall,
                'remarks' => $request->remarks
            ]);
            $user = User::where('id', Auth::user()->id)->first();
            $user->type = 0;
            $user->update();
            return $this->sendResponse('success', 'Test Score Updated Successfully');
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            $user->type = $request->type;
            $user->update();
            return $this->sendResponse('Succes', 'Test Score Updated Successfully');
        }
    }

    public function masterData()
    {
        $masterData = MasterDegree::all();
        return $this->sendResponse($masterData, 'All master data');
    }

    public function graduationData()
    {
        $graduationData = GraduationDegree::all();
        return $this->sendResponse($graduationData, 'All graduation data');
    }

    public function allDocument()
    {
        $document = UserDocument::where('created_by', Auth::user()->id)->get();
        return $this->sendResponse($document, 'All document');
    }

 
    public function allCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'course'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        
        if (! empty($request->country) || ! empty($request->course)) {
            $preferences = Preference::where('created_by', Auth::user()->id)->first();
            $courses = new Course();
            if (! empty($request->country)) {
                
                if (count(json_decode($request->country)) != 0) {
                    $country = Country::whereIn('id', json_decode($request->country))->get()
                    ->pluck('name')
                    ->toArray();
                    $courses = Course::whereIn('countryName', $country);
                }
            }
            if (! empty($preferences)) {
                
                $courses = $courses->where('tution_fee_amount', '>=', (int) $preferences->preferred_budget_min)
                ->where('tution_fee_amount', '<=', (int) $preferences->preferred_budget_max)
                ->where('area_of_interest_id', $preferences->area_of_interest);
            }
            
            $education = HighSchool::where('created_by', Auth::user()->id)->orderBy('type', 'DESC')->first();
            
            $testScore = TestScore::where('created_by', Auth::user()->id)->first();
            if (! empty($testScore)) {
                $ids=$courses->get()->pluck('id')->toArray();
                $courseEst = CourseEstDetail::where('scoreName', 'IELTS')->where('score', '<=', $testScore->overall)->whereIn('course_id',$ids)->get()->pluck('course_id')->toArray();
                $courses = $courses->whereIn('id', $courseEst);
            }
            
            if ($education->type == 3 || $education->type == 2) {
                
                if ((date('Y') - $education->passing_year) <= 7) {
                    
                    $globalCourses=GlobalCourses::where('mark_grade',$education->type);
                    if (! empty($request->course)) {
                        if (count(json_decode($request->course)) != 0) {
                            $globalCourses = $globalCourses->whereIn('id', json_decode($request->course));
                        }
                    }
                    $globalCourses=$globalCourses->get()->pluck('id')->toArray();
                    
                    if(count($globalCourses)==0)
                    {
                        $courses=[];
                    }
                    else
                    {
                        $courses=$courses->whereIn('global_course_id',$globalCourses);
                        if ($education->mark_grade == '50-60%' || $education->mark_grade == 'under 50%') {
                            $courses = $courses->where('title', 'like', '%foundation%');
                            
                        }
                        $courses = $courses->get();
                    }
                } else {
                    return $this->sendError('We will get back to you.!', [
                        'We will get back to you.!'
                    ]);
                }
            } else if ($education->type == 1) {
                if ((date('Y') - $education->passing_year) <= 3) {
                    $globalCourses=GlobalCourses::where('mark_grade',$education->type);
                    if (! empty($request->course)) {
                        if (count(json_decode($request->course)) != 0) {
                            $globalCourses = $globalCourses->whereIn('id', json_decode($request->course));
                        }
                    }
                    $globalCourses=$globalCourses->get()->pluck('id')->toArray();
                    
                    if(count($globalCourses)==0)
                    {
                        $courses=[];
                    }
                    else
                    {
                        $courses=$courses->whereIn('global_course_id',$globalCourses);
                        if ($education->mark_grade == '50-60%' || $education->mark_grade == 'under 50%') {
                            $courses = $courses->where('title', 'like', '%foundation%');
                        }
                        $courses = $courses->get();
                    }
                } else {
                    return $this->sendError('We will get back to you.!', [
                        'We will get back to you.!'
                    ]);
                }
            } else {
                $courses = [];
            }
        } else {
            $preferences = Preference::where('created_by', Auth::user()->id)->first();
            $country_id = $preferences->country_id;
            $country = Country::whereIn('id', json_decode($country_id))->get()
            ->pluck('name')
            ->toArray();
            $education = HighSchool::where('created_by', Auth::user()->id)->orderBy('type', 'DESC')->first();
            $courses = [];
            if ($education->type == 3 || $education->type == 2) {
                if ((date('Y') - $education->passing_year) <= 7) {
                    
                    $courses = Course::where('tution_fee_amount', '>=', (int) $preferences->preferred_budget_min)->where('tution_fee_amount', '<=', (int) $preferences->preferred_budget_max)
                    ->where('area_of_interest_id', $preferences->area_of_interest)
                    ->whereIn('countryName', $country);
                    if ($education->type == 3) {
                        $courses = $courses->whereIn('global_course_id', json_decode($preferences->preferred_course));
                        
                        if ($education->mark_grade <= '50-60%') {
                            $courses = $courses->where('title', 'like', '%foundation%');
                        }
                    }
                    $courses = $courses->get();
                }
            } else if ($education->type == 1) {
                if ((date('Y') - $education->passing_year) <= 3) {
                    $courses = Course::where('tution_fee_amount', '>=', (int) $preferences->preferred_budget_min)->where('tution_fee_amount', '<=', (int) $preferences->preferred_budget_max)
                    ->where('area_of_interest_id', $preferences->area_of_interest)
                    ->whereIn('countryName', $country)
                    ->get();
                }
            }
        }
        if(!empty($courses))
        {
            $university_id=$courses->pluck('university_id')->toArray();
            
            
            $city_data=University::whereIn('id',$university_id)->get()->pluck('city')->toArray();
            $city_data=array_map('trim', $city_data);
            $country_data=University::whereIn('id',$university_id)->get()->pluck('country')->toArray();
            $country_data=array_map('trim', $country_data);
            
            $city=City::whereIn('name',$city_data)->whereIn('country',$country_data)->paginate(16);
            
            
        }
        else
        {
            $city=[];
        }
        return $this->sendResponse($city, 'All Cities');
    }

    public function budget()
    {
        $columnName = 'tution_fee_amount';
        $courses = Course::selectRaw("MAX(CONVERT( $columnName,DECIMAL)) as max_tution_value, MIN(CONVERT($columnName,DECIMAL)) as min_tution_value")->whereNotNull($columnName)
            ->first()
            ->makeHidden('university_name', 'global_name', 'campus_name', 'university_city', 'university_address', 'course_intake', 'university_detail', 'university_course');
        return $this->sendResponse($courses, 'Tution fee');
    }

    public function university_search(Request $request)
    {
        $search = $request['query'] ?? "";
        $course=Course::select('university_id')->distinct()->where('title','like','%'.$search.'%')->get()->pluck('university_id')->toArray();
        
        if(!empty($course))
        {
            $universitiesIds=University::select('id')->where('name', 'like', '%'.$search.'%')->get()->pluck('id')->toArray();
            if(empty($universitiesIds))
            {
                $universitiesIds=[];
            }
            $universities=University::whereIn('id',array_merge($course,$universitiesIds));

            $universities = $universities->paginate(12);
        }
        else
        {
          
            $universities = University::where('name', 'like','%'.$search.'%');

            $universities = $universities->paginate(12);
        }
        
        
        return $this->sendResponse($universities, 'All universities.');
    }

    public function universityCourse(Request $request)
    {
        $universityCourse = Course::where('university_id',$request->university_id)->paginate(10);
        $success['course'] = $universityCourse;
        return $this->sendCourse($success, 'All courses');
        
    }
    public function destroy(Request $request)
    {
        $user=User::where('id',Auth::user()->id)->first();
        if(!empty($user))
        {
            $user->status=2;
            $user->update();
            auth()->user()
            ->tokens()
            ->delete();
            return $this->sendResponse('User deleted successfully','User is deleted');
        }
        else
        {
            return $this->sendError('User does not exist', 'User does not exist');
        }
    }
}