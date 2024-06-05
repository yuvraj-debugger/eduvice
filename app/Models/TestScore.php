<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    use HasFactory;
    protected $table = 'test_score';
    
    protected $hidden = [
        'reading',
        'writing',
        'listening',
        'speaking'
    ];
    
    protected $fillable = [
        'test_score',
        'reading',
        'writing',
        'listening',
        'speaking',
        'overall',
        'remarks',
        'type',
        'status',
        'created_by'
    ];
}
