<?php 
namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\GlobalCourses;


class GlobalCoursesExport implements FromQuery
{
    use Exportable;
    
    protected $global_course;
    
    public function __construct($global_course)
    {
        $this->global_course=$global_course;
    }
    
    public function query()
    {
        return GlobalCourses::query()->whereKey($this->global_course);
    }
}
?>