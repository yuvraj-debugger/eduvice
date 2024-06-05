<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOpenIntake extends Model
{
    use HasFactory;

    protected $table = 'course_open_intake';

    protected $fillable = [
        'intakeName',
        'intakeYear',
        'university_id',
        'course_id',
        'programId'
    ];
}
