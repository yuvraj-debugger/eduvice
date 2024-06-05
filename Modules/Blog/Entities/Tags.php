<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tags extends Model
{
    use HasFactory;

    protected $table = 'blog_tags';
    
    protected $fillable = [
        'title',
        'meta_title',
        'slug',
        'content',
        'created_by'
    ];
    
    public $incrementing = true;
    
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('title', 'like', $term)
            ->orwhere('meta_title', 'like', $term);
        });
    }
}
