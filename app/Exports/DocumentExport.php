<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\AreaOfInterest;
use App\Models\UserDocument;

class DocumentExport implements FromQuery
{
    use Exportable;

    protected $document;

    public function __construct($document)
    {
        $this->document=$document;
    }

    public function query()
    {
        return UserDocument::query()->whereKey($this->document);
    }
}
