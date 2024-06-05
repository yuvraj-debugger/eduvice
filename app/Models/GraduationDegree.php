<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraduationDegree extends Model
{
    use HasFactory;
    protected $table = 'graduation';
    protected $fillable = [
        'name',
        'type',
        'status',
        'created_by',
    ];
}
