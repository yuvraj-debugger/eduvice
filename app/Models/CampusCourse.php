<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusCourse extends Model
{
    use HasFactory;
    protected $table = 'campus_course';
    
    protected $fillable = [
        'course_id',
        'campus_id',
        'status',
        'type',
        'created_by',
        'campusId',
        'campusName',
        'tuitionFee',
        'programCode',
        'applicationFee'
    ];
    
}
