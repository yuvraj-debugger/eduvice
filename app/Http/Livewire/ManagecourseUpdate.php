<?php
namespace App\Http\Livewire;

use App\Models\CampusCourse;
use App\Models\Course;
use App\Models\University;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\UniversityCampus;
use App\Models\GlobalCourses;
use App\Models\Currency;
use App\Models\CourseEstDetail;
use App\Models\AreaOfInterest;
use App\Models\CourseIntake;

class ManagecourseUpdate extends Component
{

    public $university_id, $campus_id, $global_course_id, $title, $duration_number, $duration_day, $duration_month, $duration_year, $tution_fee_amount, $application_fee_amount, $tution_fee_currency, $open_intake, $key_highlight;

    public $application_fee_currency;

    public $intake = [];

    public $course_id;

    public $area_of_interest_id;

    public $ielts_score, $ielts_min_score, $toefl_score, $toefl_min_score, $pte_score, $pte_min_score, $duolingo_score, $duolingo_min_score;

    public $duration_option;

    public $inputs = [];

    public $campus = [];

    public $updatedCampus = NULL;

    public $university = NULL;

    protected $rules = [
        'university_id' => 'required',
        'campus_id' => 'required',
        'area_of_interest_id' => 'required',
        'global_course_id' => 'required',
        'title' => 'required',
        'intake' => 'required',
        'duration_number' => 'required',
        'duration_option' => 'required',
        'tution_fee_amount' => 'required',
        'tution_fee_currency' => 'required',
        'application_fee_amount' => 'required',
        'application_fee_currency' => 'required',
        'open_intake' => 'required',
        'key_highlight' => 'required',
        'ielts_score' => 'required',
        'ielts_min_score' => 'required',
        'toefl_score' => 'required',
        'toefl_min_score' => 'required',
        'pte_score' => 'required',
        'pte_min_score' => 'required',
        'duolingo_score' => 'required',
        'duolingo_min_score' => 'required'
    ];

    public function mount($course_id)
    {
        $this->course_id = $course_id;
        $managecourses = Course::where('id', $this->course_id)->first();
        $courseDetail = CourseEstDetail::where('course_id', $this->course_id)->get();
        $campusIds = CampusCourse::where('course_id', $course_id)->get()
            ->pluck('campusId')
            ->toArray();

        $this->campus_id = $campusIds;
        $this->university_id = $managecourses->university_id;
        $this->area_of_interest_id = $managecourses->area_of_interest_id;
        $this->global_course_id = $managecourses->global_course_id;
        $this->title = $managecourses->title;
        $courseIntake = CourseIntake::where('course_id', $course_id)->get()
            ->pluck('intake')
            ->toArray();

        $this->intake = $courseIntake;
        $this->open_intake = $managecourses->open_intake;

        foreach ($courseDetail as $courseValue) {
            if ($courseValue->scoreName == 'IELTS') {
                $this->ielts_score = $courseValue->score;
                $this->ielts_min_score = $courseValue->min_score;
            } elseif ($courseValue->scoreName == 'TOEFL') {
                $this->toefl_score = $courseValue->score;
                $this->toefl_min_score = $courseValue->min_score;
            } elseif ($courseValue->scoreName == 'PTE') {
                $this->pte_score = $courseValue->score;
                $this->pte_min_score = $courseValue->min_score;
            } elseif ($courseValue->scoreName == 'Duolingo') {
                $this->duolingo_score = $courseValue->score;
                $this->duolingo_min_score = $courseValue->min_score;
            }
        }

        if ($managecourses->type) {
            $duration = $managecourses->duration;
            $duration = explode(' ', $duration);
            $this->duration_number = trim($duration[0]);
            if (trim($duration[1]) == 'Months') {
                $this->duration_option = 2;
            }
            if (trim($duration[1]) == 'Days') {
                $this->duration_option = 1;
            }
            if (trim($duration[1]) == 'Years') {
                $this->duration_option = 3;
            }
        } else {
            $this->duration_number = $managecourses->duration_number;
            $this->duration_option = $managecourses->duration_option;
        }

        $this->tution_fee_amount = $managecourses->tution_fee_amount;
        $this->tution_fee_currency = $managecourses->tution_fee_currency;
        $this->application_fee_amount = $managecourses->application_fee_amount;
        $this->application_fee_currency = $managecourses->application_fee_currency;
        $this->key_highlight = $managecourses->key_highlight;
        $this->ielts = $managecourses->ielts;
        $this->toefl = $managecourses->toefl;
        $this->pte = $managecourses->pte;
        $this->duolingo = $managecourses->duolingo;
    }

    public function store()
    {
        $this->validate([
            'campus_id' => 'required'
        ]);

        $id = [];
        
        $campusCourse = CampusCourse::where('course_id', $this->course_id)->get();
        if (! empty($campusCourse)) {
            foreach ($campusCourse as $campusCourseId) {
                $campusCourseId = CampusCourse::findOrFail($campusCourseId->id);
                $campusCourseId->delete();
            }
        }
        foreach ($this->campus_id as $campus_id) {
            if (! empty($campus_id)) {
                if (! is_int($campus_id)) {
                    $campusId = UniversityCampus::where('university_id', $this->university_id)->first();
                    $campus_id = CampusCourse::updateOrCreate([
                        'course_id' => $this->course_id,
                        'campusId' => $campus_id
                    ], [
                        'campus_id' => $campusId->id
                    ]);
                } else {
                    $compusid = CampusCourse::where('id', $campus_id)->first();
                    $campus_id = CampusCourse::create([
                        'course_id' => $this->course_id,
                        'campusId' => $compusid->campusName,
                        'campus_id' => $this->campus_id
                    ]);
                }
            }
        }

        $intake = CourseIntake::where('course_id', $this->course_id)->get();
        if (! empty($intake)) {
            foreach ($intake as $intakes) {
                $intakes = CourseIntake::findOrFail($intakes->id);
                $intakes->delete();
            }
        }
        $intake = $this->intake;
        $i = 0;
        foreach ($intake as $intakes){
            if(! empty($intakes) && ! empty($this->intake[$i])){
                $intakeCourse= CourseIntake::create([
                    'course_id' => $this->course_id,
                    'university_id'=>$this->university_id,
                    'intake'=>$this->intake[$i]
                ]);
            }
            ++$i;
        }
        Course::where('id', $this->course_id)->update([
            'university_id' => $this->university_id,
            'global_course_id' => $this->global_course_id,
            'area_of_interest_id' => $this->area_of_interest_id,
            'title' => $this->title,
            'open_intake' => $this->open_intake,
            'duration_number' => $this->duration_number,
            'duration_option' => $this->duration_option,
            'tution_fee_amount' => $this->tution_fee_amount,
            'tution_fee_currency' => $this->tution_fee_currency,
            'application_fee_amount' => $this->application_fee_amount,
            'application_fee_currency' => $this->application_fee_currency,
            'key_highlight' => $this->key_highlight,
            'created_by' => Auth::user()->id
        ]);

        CourseEstDetail::updateOrCreate([
            'course_id' => $this->course_id,
            'scoreName' => 'IELTS'
        ], [
            'score' => $this->ielts_score,
            'min_score' => $this->ielts_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $this->course_id,
            'scoreName' => 'TOEFL'
        ], [
            'score' => $this->toefl_score,
            'min_score' => $this->toefl_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $this->course_id,
            'scoreName' => 'TOEFL'
        ], [
            'score' => $this->pte_score,
            'min_score' => $this->pte_min_score
        ]);
        CourseEstDetail::updateOrCreate([
            'course_id' => $this->course_id,
            'scoreName' => 'Duolingo'
        ], [
            'score' => $this->duolingo_score,
            'min_score' => $this->duolingo_min_score
        ]);

        return redirect(route('admin.manage.index'))->with('success', 'Manage Course updated successfully');
    }

    public function render()
    {
        $manageCourses = Course::where('id', $this->course_id)->first();
        $courseDetail = CourseEstDetail::where('course_id', $this->course_id)->first();
        $areaofinterest = AreaOfInterest::all();
        $universityName = University::all();
        $campusName = UniversityCampus::all();
        $globalCourse = GlobalCourses::all();
        $currency = Currency::all();

        return view('livewire.managecourse-update', [
            'manageCourses' => $manageCourses,
            'universityName' => $universityName,
            'campusName' => $campusName,
            'globalCourse' => $globalCourse,
            'currency' => $currency,
            'courseDetail' => $courseDetail,
            'areaofinterests' => $areaofinterest
        ]);
    }

    public function updatedUniversity($university_id)
    {
        if (! is_null($university_id)) {
            $this->updatedCampus = UniversityCampus::where('university_id', $university_id)->get();
        }
    }
}
