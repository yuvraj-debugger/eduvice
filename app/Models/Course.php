<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $appends = [
        'university_name',
        'global_name',
        'campus_name',
        'university_city',
        'university_address',
        'course_intake',
        'university_detail',
        'university_course'
    ];
    protected $fillable = [
        'university_id',
        'programId',
        'interest_id',
        'institutionId',
        'currencySymbol',
        'currencyCode',
        'countryName',
        'isShortlisted',
        'programUrl',
        'duration',
        'programName',
        'hasLogo',
        'logo',
        'min_requirement',
        'note',
        'institutionName',
        'campusDetails',
        'openIntake',
        'intakeDetails',
        'etsDetails',
        'study_level_id',
        'discipline_id',
        'campus_id',
        'global_course_id',
        'title',
        'intake',
        'duration_number',
        'duration_option',
        'duration_day',
        'duration_month',
        'duration_year',
        'tution_fee_currency',
        'tution_fee_amount',
        'application_fee_currency',
        'application_fee_amount',
        'open_intake',
        'key_highlight',
        'ielts',
        'toefl',
        'pte',
        'duolingo',
        'eligibility_criteriat',
        'status',
        'type',
        'created_by',
        'area_of_interest_id'
    ];
    
    protected $hidden = ['campusDetails','openIntake','intakeDetails','etsDetails','intake'];
    
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('title', 'like', $term);
        });
    }
    public function getUniversity()
    {
        return $this->hasOne(University::class, 'id','university_id');
        
    }
    public function University()
    {
        $university =University::where('id',$this->university_id)->first();
        
        return $university;
        
    }
    public function AreaInterst()
    {
        $interest = AreaOfInterest::where('id',$this->area_of_interest_id)->first();
        return ! empty($interest) ? $interest->title : '';
    }
    public function globalCourse()
    {
        $globalCourse = GlobalCourses::where('id',$this->global_course_id)->first();
        return ! empty($globalCourse) ? $globalCourse->title : '';
    }
    public function campusDetails()
    {
        $campusDetail = CampusCourse::where('course_id',$this->id)->get();
        return ! empty($campusDetail) ? $campusDetail : '';
    }
    public function CampusApplication()
    {
        $applicationFee = CampusCourse::where('course_id',$this->id)->get()->pluck('applicationFee')->toArray();
        return  ! empty($applicationFee) ? $applicationFee: '' ;
        
    }
    public function courseIntake()
    {
        $courseIntake = CourseIntake::where('course_id',$this->id)->get()->pluck('intake')->toArray();
        return ! empty($courseIntake) ? $courseIntake : '';
        
    }
    public function courseOpenIntake()
    {
        $courseOpen = CourseOpenIntake::where('course_id',$this->id)->get()->pluck('intakeYear','intakeName')->toArray();
        return ! empty($courseOpen) ? $courseOpen : '';
        
    }
    public function getCourseEstDetail()
    {
        return $this->hasMany(CourseEstDetail::class, 'course_id','id');
        
    }
    public function getcampusDetailsAttribute()
    {
        return false;
    }
    public function getUniversityNameAttribute()
    {
        $university = University::where('id',$this->university_id)->first();
        return ! empty($university) ? $university->name : '';
         
    }
    public function getGlobalNameAttribute()
    {
        $globalName = GlobalCourses::where('id',$this->global_course_id)->first();
        return ! empty($globalName) ? $globalName->title: '';
    }
    public function getCampusNameAttribute()
    {
        $campusName = CampusCourse::where('course_id',$this->id)->first();
        return ! empty($campusName)? $campusName->campusName : '';
    }
    public function getUniversityCityAttribute()
    {
        $universityCity = University::where('id',$this->university_id)->first();
        return ! empty($universityCity) ? $universityCity->city : '';
    }
    public function getUniversityAddressAttribute()
    {
        $universityAddress = University::where('id',$this->university_id)->first();
        return ! empty($universityAddress) ? $universityAddress->address : '';
    }
    public function getCourseIntakeAttribute()
    {
        $courseIntake = CourseOpenIntake::where('course_id',$this->id)->get()->pluck('intakeName')->toArray();
        return ! empty($courseIntake) ? implode(',',$courseIntake) : '';
    }
    public function getUniversityDetailAttribute()
    {
        $universityDetails = University::select('name','admission_contact_number','admission_email','admission_website','about' ,'logo')->where('id',$this->university_id)->first();
        return $universityDetails;
    }
    public function getUniversityCourseAttribute()
    {
        $universitCourse = Course::select('id','programName')->where('university_id',$this->university_id)->get()->makeHidden(['university_name','global_name','campus_name','university_city','university_address','course_intake','university_detail','university_course']);
        return ! empty($universitCourse) ? $universitCourse : '';
    }
    
}
