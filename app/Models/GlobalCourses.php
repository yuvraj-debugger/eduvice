<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalCourses extends Model
{
    use HasFactory;
    protected $table = 'global_course';
    
    protected $appends = [
        'selected'
    ];/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'mark_grade',
        'type',
        'tags',
        'created_by',
        'global_course_id'
    ];
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('global_course.title', 'like', $term)->orwhere('global_course.tags','like',$term);
        });
    }
    /**
     * Get the user that owns the phone.
     */
    public function areaOfInterest() 
    {
        return $this->belongsTo(AreaOfInterest::class, 'interest_id', 'id');
    }
    public function getSelectedAttribute()
    {
        $globalCourse = Preference::where('created_by', Auth::user()->id)->first();
        if ($globalCourse) {
            $globalCourse_array =json_decode($globalCourse->preferred_course,true);
            if (in_array($this->id, $globalCourse_array)) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}
