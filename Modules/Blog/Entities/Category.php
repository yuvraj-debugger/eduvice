<?php
namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'blog_category';

    protected $fillable = [
        'title',
        'parent_id',
        'meta_title',
        'slug',
        'content'
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
