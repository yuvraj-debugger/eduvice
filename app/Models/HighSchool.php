<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighSchool extends Model
{
    use HasFactory;
    protected $table = 'user_education_detail';
    
    protected $fillable = [
        'class',
        'mark_grade',
        'passing_year',
        'institution',
        'type',
        'status',
        'created_at',
        'updated_at',
        'created_by'
    ];
}
