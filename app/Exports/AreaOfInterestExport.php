<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\AreaOfInterest;

class AreaOfInterestExport implements FromQuery
{
    use Exportable;

    protected $area_of_interest;

    public function __construct($area_of_interest)
    {
        $this->area_of_interest=$area_of_interest;
    }

    public function query()
    {
        return AreaOfInterest::query()->whereKey($this->area_of_interest);
    }
}
