<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEstDetail extends Model
{
    use HasFactory;

    protected $table = 'course_est_detail';

    protected $fillable = [
        'score',
        'min_score',
        'scoreName',
        'university_id',
        'course_id',
        'programId'
    ];
}
