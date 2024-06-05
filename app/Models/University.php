<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class University extends Model
{
    use HasFactory;
    protected $table = 'universities';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     * 
     */
    protected $appends = [
        'course',
        'campus_data',
        'open_intake',
        'course_intake',
        'est_details',
        'campus'
    ];
    protected $fillable = [
        'name',
        'address',
        'city',
        'province',
        'country',
        'admission_contact_person',
        'admission_contact_number',
        'admission_email',
        'admission_website',
        'placement_contact_person',
        'placement_contact_number',
        'placement_email',
        'placement_website',
        'about',
        'logo',
        'type',
        'created_by',
        'institutionId',
        'shoreType',
        'is_pgwp',
        'is_public',
        'institutionType',
        'campusName',
        'openIntake',
        'institutionUrl'
    ];
    protected $hidden = ['course','campus_data','open_intake','course_intake','est_details'];
    
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)->orwhere('address','like',$term);
        });
    }
    public function UniversityCampus()
    {
        return $this->hasMany(UniversityCampus::class, 'university_id','id');
    }
    public function UniversityOpenIntake()
    {
        return $this->hasMany(OpenIntake::class, 'university_id','id');
    }
    public function UniversityCourse()
    {
        return $this->hasMany(Course::class, 'university_id','id');
    }
    public function getCourseAttribute()
    {
        $duration = Course::where('university_id', $this->id)->get();
            return  $duration;
    }
    public function getCampusDataAttribute()
    {
        $campusDetails = UniversityCampus::where('university_id',$this->id)->get();
        return $campusDetails;
        
    }
    public function getOpenIntakeAttribute()
    {
        $openIntake = OpenIntake::where('university_id',$this->id)->get();
        return $openIntake;
    }
    public function getCourseIntakeAttribute()
    {
        $courseIntake = CourseIntake::where('university_id',$this->id)->get();
        return $courseIntake;
    }
    public function getEstDetailsAttribute()
    {
        $estDetails = CourseEstDetail::where('university_id',$this->id)->get();
        return $estDetails;
    }
    public function getCampusAttribute()
    {
        $campusName = UniversityCampus::where('university_id',$this->id)->get();
        return ! empty($campusName) ? $campusName : '';
    }
}
