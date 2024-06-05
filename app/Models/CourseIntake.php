<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseIntake extends Model
{
    use HasFactory;

    protected $table = 'course_intake';

    protected $fillable = [
        'intake',
        'intakeId',
        'university_id',
        'course_id',
        'programId'
    ];
}
