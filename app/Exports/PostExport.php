<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Blog\Entities\Posts;

class PostExport implements FromQuery
{
    use Exportable;

    protected $post;

    public function __construct($post)
    {
        $this->post=$post;
    }

    public function query()
    {
        return Posts::query()->whereKey($this->post);
    }
}
