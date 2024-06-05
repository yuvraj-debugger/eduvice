<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\University;
use App\Models\UniversityCampus;
use App\Models\GlobalCourses;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Models\CampusCourse;
use App\Models\Currency;
use App\Models\CourseEstDetail;
use App\Models\AreaOfInterest;
use App\Models\CourseIntake;


class ManagecourseCreate extends Component
{
    public $university_id,$campus_id,$global_course_id,$title,$intake,$duration_number,$tution_fee_amount,$application_fee_amount,$tution_fee_currency,$open_intake,$key_highlight;
    public $application_fee_currency;
    public $area_of_interest_id;
    public $ielts_score, $ielts_min_score, $toefl_score, $toefl_min_score, $pte_score, $pte_min_score, $duolingo_score, $duolingo_min_score;
    public $duration_option;
    
    protected $rules = [
        'university_id' => 'required',
        'area_of_interest_id'=>'required',
        'campus_id' => 'required',
        'global_course_id' => 'required',
        'title' => 'required',
        'intake' => 'required',
        'duration_number' => 'required',
        'duration_option' => 'required',
        'tution_fee_amount' => 'required',
        'tution_fee_currency'=>'required',
        'application_fee_amount' => 'required',
        'application_fee_currency'=>'required',
        'open_intake' => 'required',
        'key_highlight' => 'required',
    ];
    
    public function store()
    {
        $this->validate();
        $duration= $this->duration_number.' '.$this->duration_option;
        $course=Course::create([
            'university_id' => $this->university_id,
            'global_course_id' => $this->global_course_id,
            'area_of_interest_id'=>$this->area_of_interest_id,
            'title'=> $this->title,
            'duration_number'=> $this->duration_number,
            'duration_option'=>$this->duration_option,
            'duration'=>$duration,
            'tution_fee_amount'=>$this->tution_fee_amount,
            'tution_fee_currency'=> $this->tution_fee_currency,
            'application_fee_amount'=>$this->application_fee_amount,
            'application_fee_currency'=>$this->application_fee_currency,
            'open_intake'=>$this->open_intake,
            'key_highlight'=>$this->key_highlight,
            
            
        ]);
        $intake = $this->intake;
        $i = 0;
        foreach ($intake as $intakes){
            if(! empty($intakes) && ! empty($this->intake[$i])){
                $intakeCourse= CourseIntake::create([
                    'course_id' => $course->id,
                    'university_id'=>$this->university_id,
                    'intake'=>$this->intake[$i]
                ]);
            }
            ++$i;
        }
        CourseEstDetail::updateOrCreate([
            'course_id' => $course->id,
            'scoreName' => 'IELTS'
        ], [
            'score' => $this->ielts_score,
            'min_score' => $this->ielts_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $course->id,
            'scoreName' => 'TOEFL'
        ], [
            'score' => $this->toefl_score,
            'min_score' => $this->toefl_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $course->id,
            'scoreName' => 'PTE'
        ], [
            'score' => $this->pte_score,
            'min_score' => $this->pte_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $course->id,
            'scoreName' => 'Duolingo'
        ], [
            'score' => $this->duolingo_score,
            'min_score' => $this->duolingo_min_score
        ]);
        
        $campus_id = $this->campus_id;
        $j = 0;
        foreach ($campus_id as $campus_ids){
            if(! empty($campus_ids) && ! empty($this->campus_id[$j])){
                $campusId = CampusCourse::create([
                    'course_id' => $course->id,
                    'tuitionFee'=> $this->tution_fee_currency.' '.$this->tution_fee_amount,
                    'applicationFee'=>$this->application_fee_currency.' '.$this->application_fee_amount,
                    'campusId' => $this->campus_id[$j],
                    'campus_id'=>$this->campus_id[$j]
                ]);
            }
            ++$j;
        }
        return redirect(route('admin.manage.index'))->with('success', 'Courses added successfully');
    }
    
    public function render()
    {
        $allUniverisity = University::all();
        $globalCourse = GlobalCourses::all();
        $allCampus = UniversityCampus::all();
        $areaofinterests = AreaOfInterest::all();
        $currency = Currency::all();
        return view('livewire.managecourse-create',compact('allUniverisity','allCampus','globalCourse','currency','areaofinterests'));
    }
}
