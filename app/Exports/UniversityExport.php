<?php 
namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\University;


class UniversityExport implements FromQuery
{
    use Exportable;
    
    protected $university;
    
    public function __construct($university)
    {
        $this->university=$university;
    }
    
    public function query()
    {
        return University::query()->whereKey($this->university);
    }
}

?>