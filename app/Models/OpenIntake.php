<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenIntake extends Model
{
    use HasFactory;
    
    protected $table = 'open_intake';
    
    protected $fillable = [
        'intakeName',
        'intakeYear',
        'university_id',
        'type',
        'status'
    ];
}
