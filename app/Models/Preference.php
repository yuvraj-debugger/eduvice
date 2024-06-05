<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Foreach_;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'preferences';
    
    protected $appends = [
        'area_interest'
       
    ];
    
    protected $fillable = [
        'area_of_interest',
        'country_id',
        'preferred_course',
        'preferref_budget',
        'preferred_budget_max',
        'preferred_budget_min',
        'type',
        'status',
        'created_at',
        'updated_at',
        'created_by'
    ];
    public function getAreaInterestAttribute()
    {
        if(! empty($this->area_of_interest)){
            $areaInterest = AreaOfInterest::where('id',$this->area_of_interest)->first();
            return ! empty($areaInterest) ? $areaInterest->title : '';
        }else{
            return false;
        }
    }
    public function getAreaInterest()
    {
           return $this->hasOne(AreaOfInterest::class,'id','area_of_interest');
    }
    public function getCourse()
    {
        $preference = json_decode($this->preferred_course);
        $course = Course::whereIn('id',$preference)->get()->pluck('title')->toArray();
        return ! empty($course) ? implode(',',$course) : '';
    }
    public function getGlobalCourse()
    {
        $preference = json_decode($this->preferred_course);
        $course = GlobalCourses::whereIn('id',$preference)->get()->pluck('title')->toArray();
        return ! empty($course) ? implode(',',$course) : '';
    }
}
