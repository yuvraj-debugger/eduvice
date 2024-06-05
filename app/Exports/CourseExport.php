<?php 
namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\Course;


class CourseExport implements FromQuery
{
    use Exportable;
    
    protected $course;
    
    public function __construct($course)
    {
        $this->course=$course;
    }
    
    public function query()
    {
        return Course::query()->whereKey($this->course);
    }
}
?>