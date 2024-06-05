<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\HighSchool;
use App\Models\TestScore;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;
use App\Models\University;
use App\Models\Course;
use App\Models\Country;
use App\Models\UserDocument;
use App\Models\City;
use App\Models\CourseEstDetail;
use App\Models\GlobalCourses;

class UniversityController extends BaseController
{

    public function search(Request $request)
    {
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
            
            if (! empty($request->city)) {
                if (count(json_decode($request->city)) != 0) {
                    $city = City::whereIn('id', json_decode($request->city))->get()
                    ->pluck('name')
                    ->toArray();
                    
                    $university = University::whereIn('city', $city)->get()
                    ->pluck('id')
                    ->toArray();
                    $courses = $courses->whereIn('university_id', $university);
                }
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
                        if(!empty($request->keyword))
                        {
                            $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                        }
                        else
                        {
                            $courses = $courses->paginate(16);
                        }
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
                        if(!empty($request->keyword))
                        {
                            $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                        }
                        else
                        {
                            $courses = $courses->paginate(16);
                        }
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
                    if(!empty($request->keyword))
                    {
                        $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                    }
                    else
                    {
                        $courses = $courses->paginate(16);
                    }
                }
            } else if ($education->type == 1) {
                if ((date('Y') - $education->passing_year) <= 3) {
                    $courses = Course::where('tution_fee_amount', '>=', (int) $preferences->preferred_budget_min)->where('tution_fee_amount', '<=', (int) $preferences->preferred_budget_max)
                    ->where('area_of_interest_id', $preferences->area_of_interest)
                    ->whereIn('countryName', $country);
                    
                    if(!empty($request->keyword))
                    {
                        $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                    }
                    else
                    {
                        $courses = $courses->paginate(16);
                    }
                }
            }
        }
        $success['course'] = $courses;
        return $this->sendCourse($success, 'All courses');
    }
    

    public function searchUniversity(Request $request)
    {
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
            
            if (! empty($request->city)) {
                if (count(json_decode($request->city)) != 0) {
                    $city = City::whereIn('id', json_decode($request->city))->get()
                    ->pluck('name')
                    ->toArray();
                    
                    $university = University::whereIn('city', $city)->get()
                    ->pluck('id')
                    ->toArray();
                    $courses = $courses->whereIn('university_id', $university);
                }
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
                        if(!empty($request->keyword))
                        {
                            $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                        }
                        else
                        {
                            $courses = $courses->paginate(16);
                        }
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
                        if(!empty($request->keyword))
                        {
                            $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                        }
                        else
                        {
                            $courses = $courses->paginate(16);
                        }
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
                    if(!empty($request->keyword))
                    {
                        $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16); 
                    }
                    else
                    {
                        $courses = $courses->paginate(16);
                    }
                }
            } else if ($education->type == 1) {
                if ((date('Y') - $education->passing_year) <= 3) {
                    $courses = Course::where('tution_fee_amount', '>=', (int) $preferences->preferred_budget_min)->where('tution_fee_amount', '<=', (int) $preferences->preferred_budget_max)
                    ->where('area_of_interest_id', $preferences->area_of_interest)
                    ->whereIn('countryName', $country);
                    
                    if(!empty($request->keyword))
                    {
                        $courses=$courses->where('title','like','%'.$request->keyword.'%')->paginate(16);
                    }
                    else
                    {
                        $courses = $courses->paginate(16);
                    }
                }
            }
        }
        $success['course'] = $courses;
        return $this->sendCourse($success, 'All courses');
    }

    public function getUniversity(Request $request)
    {
        $preferences = Preference::where('created_by', Auth::user()->id)->first();
        $country_id = $preferences->country_id;
        $country = Country::whereIn('id', json_decode($country_id))->get()
            ->pluck('name')
            ->toArray();

        $education = HighSchool::where('created_by', Auth::user()->id)->orderBy('type', 'DESC')->first();

        $courses = [];
        if ($education->type == 3 || $education->type == 2) {
            if ((date('Y') - $education->passing_year) <= 7) {

                $courses = Course::where('tution_fee_amount', '<=', $preferences->preferred_budget_min)->where('tution_fee_amount', '>=', $preferences->preferred_budget_max)
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
                $courses = Course::where('tution_fee_amount', '<=', $preferences->preferred_budget_min)->where('tution_fee_amount', '>=', $preferences->preferred_budget_max)
                    ->where('area_of_interest_id', $preferences->area_of_interest)
                    ->get();
            }
        }
        $success['course'] = $courses;
        return $this->sendResponse($success, 'All courses');
    }

    public function univerisityData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $university_id = Course::where('id', $request->course_id)->first();
        $success['course'] = $university_id;
        return $this->sendResponse($success, 'Course');
    }
}
?>