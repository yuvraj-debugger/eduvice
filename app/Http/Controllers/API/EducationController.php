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
use App\Models\User;

class EducationController extends BaseController
{

    public function educationDetail(Request $request)
    {
        $userExist = HighSchool::where( 'created_by',Auth::user()->id)->first();
        if(! empty($userExist->created_by) == Auth::user()->id){
            return $this->sendResponse('success', 'This student already submitted form');
        }else{
            
            $validator = Validator::make($request->all(), [
                'class' => 'required',
                'mark_grade' => 'required',
                'passing_year' => 'required|digits:4|integer',
                'area_of_interest' => 'required|integer|min:1',
                'preferred_course' => 'required',
                'preferred_budget_min' => 'required',
                'preferred_budget_max' => 'required'
            ]);
            
            if ($validator->fails()) {  
                return $this->sendError('Error validation', $validator->errors());
            }
            if(empty($request->test_score_type))
            {
                $validator = Validator::make($request->all(), [
                    'test_score'=>'required',
                    'overall'=>'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Error validation', $validator->errors());
                }
                $testScore = TestScore::create([
                    'test_score' =>$request->test_score,
                    'overall' => $request->overall,
                    'remarks' => $request->remarks,
                    'type'=>$request->test_score_type,
                    'created_by' => Auth::user()->id
                ]);
            }
            if(!empty($request->class))
            {
                $validator = Validator::make($request->all(), [
                    'class'=>'required',
                    'mark_grade'=>'required',
                    'passing_year'=>'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Error validation', $validator->errors());
                }
                $highSchool = HighSchool::create([
                    'class' => $request->class,
                    'mark_grade' => $request->mark_grade,
                    'passing_year' => $request->passing_year,
                    'institution' => $request->institution,
                    'type'=>1,
                    'created_by' => Auth::user()->id
                ]);
            }
            
            if(!empty($request->graduation)&&!empty($request->graduation_mark_grade)&&!empty($request->graduation_passing_year)&&!empty($request->graduation_institution)){
                $validator = Validator::make($request->all(), [
                    'graduation'=>'required',
                    'graduation_mark_grade'=>'required',
                    'graduation_passing_year'=>'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Error validation', $validator->errors());
                }
                $graduation = HighSchool::create([
                    'class' => $request->graduation,
                    'mark_grade' => $request->graduation_mark_grade,
                    'passing_year' => $request->graduation_passing_year,
                    'institution' => $request->graduation_institution,
                    'type'=>2,
                    'created_by' => Auth::user()->id
                ]);
            }
            
            if(! empty($request->master) && ! empty($request->master_mark_grade) && ! empty($request->master_passing_year) && ! empty($request->master_institution)){
                $validator = Validator::make($request->all(), [
                    'master'=>'required',
                    'master_mark_grade'=>'required',
                    'master_passing_year'=>'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Error validation', $validator->errors());
                }
                $master= HighSchool::create([
                    'class' => $request->master,
                    'mark_grade' => $request->master_mark_grade,
                    'passing_year' => $request->master_passing_year,
                    'institution'=>$request->master_institution,
                    'type'=>3,
                    'created_by'=>Auth::user()->id
                ]);
            }
            
            $preference = Preference::create([
                'area_of_interest'=>$request->area_of_interest,
                'country_id'=>$request->country_id,
                'preferred_course'=>$request->preferred_course,
                'preferred_budget_min'=>$request->preferred_budget_min,
                'preferred_budget_max'=>$request->preferred_budget_max,
                'created_by'=>Auth::user()->id
            ]);
            
            if (! empty(Auth::user()->id) && ! empty($request->test_score_type)) {
                $user = User::find(Auth::user()->id);
                $user->type = $request->test_score_type;
                $user->remarks = $request->remarks;
                $user->step = 1;
                $user->update();
            }
            return $this->sendResponse('success', 'Student application form submitted.');
            
          
        }
    }
}

?>