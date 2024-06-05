<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use App\Exports\CourseExport;

class ManagecourseIndex extends Component
{
    
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'id';
    
    public $sortDirection = 'DESC';
    
    
    public function getCourseProperty()
    {
        return Course::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        
    }
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function render()
    {
        $courses = Course::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.managecourse-index',compact('courses'));
    }
    public function deleteRecords()
    {
        Course::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    public function deleteRecord($university_id)
    {
        $course_delete = Course::findOrFail($university_id);
        $course_delete->delete();
        session()->flash('info', 'Record deleted successfully');
    }
    public function exportSelected()
    {
        return (new CourseExport($this->checked))->download('course.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->course->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    public function isChecked($course_id)
    {
        return in_array($course_id, $this->checked);
    }
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
    
    
    
}
