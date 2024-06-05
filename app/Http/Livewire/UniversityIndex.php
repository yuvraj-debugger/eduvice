<?php

namespace App\Http\Livewire;

use App\Models\University;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UniversityCampus;
use App\Exports\UniversityExport;

class UniversityIndex extends Component
{
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'id';
    
    public $sortDirection = 'DESC';
    
    public function getUniversityProperty()
    {
       return  University::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        
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
        $universities = University::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.university-index',compact('universities'));
    }
    
    public function deleteRecords()
    {
        University::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    
    public function deleteRecord($university_id)
    {
        $university = University::findOrFail($university_id);
        $university->delete();
        UniversityCampus::where('university_id',$university_id)->delete();
        $this->checked = array_diff($this->checked, [
            $university_id
        ]);
        session()->flash('info', 'Record deleted successfully');
    }
    
    public function exportSelected()
    {
        return (new UniversityExport($this->checked))->download('university.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->University->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    
    public function isChecked($university_id)
    {
        return in_array($university_id, $this->checked);
    }
    
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
}
