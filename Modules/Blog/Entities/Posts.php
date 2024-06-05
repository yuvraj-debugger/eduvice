<?php
namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'blog_post';

    protected $fillable = [
        'title',
        'feature_image',
        'parent_id',
        'meta_title',
        'slug',
        'summary',
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
