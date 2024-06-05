<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Blog\Entities\Category;

class CategoryExport implements FromQuery
{
    use Exportable;

    protected $category;

    public function __construct($category)
    {
        $this->category=$category;
    }

    public function query()
    {
        return Category::query()->whereKey($this->category);
    }
}
