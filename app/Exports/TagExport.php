<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Blog\Entities\Tags;

class TagExport implements FromQuery
{
    use Exportable;

    protected $tag;

    public function __construct($post)
    {
        $this->tag=$tag;
    }

    public function query()
    {
        return Tags::query()->whereKey($this->tag);
    }
}
