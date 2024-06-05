<?php

namespace App\Http\Livewire;

use App\Models\GlobalCourses;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\GlobalCoursesExport;

class GlobalcoursesIndex extends Component
{
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'id';
    
    public $sortDirection = 'desc';
    
    public function getGlobalCoursesProperty()
    {
        return GlobalCourses::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
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
        $globalCourses = GlobalCourses::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.globalcourses-index', [
            'globalCourses' => $globalCourses
        ]);
    }
    
    public function deleteRecords()
    {
        GlobalCourses::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    
    public function deleteRecord($globalCourses_id)
    {
        $globalCourses = GlobalCourses::findOrFail($globalCourses_id);
        $globalCourses->delete();
        $this->checked = array_diff($this->checked, [
            $globalCourses_id
        ]);
        session()->flash('info', 'Record deleted successfully');
    }
    
    public function exportSelected()
    {
        return (new GlobalCoursesExport($this->checked))->download('globalcourses.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->globalCourses->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    
    public function isChecked($globalCourses_id)
    {
        return in_array($globalCourses_id, $this->checked);
    }
    
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
}
