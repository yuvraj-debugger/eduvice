<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDegree extends Model
{
    use HasFactory;
    protected $table = 'master_degree';
    protected $fillable = [
        'name',
        'type',
        'status',
        'created_by',
    ];
}
