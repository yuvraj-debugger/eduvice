<?php

namespace App\Http\Livewire;

use App\Exports\AreaOfInterestExport;
use App\Models\AreaOfInterest;
use Livewire\Component;
use Livewire\WithPagination;

class AreaofinterestIndex extends Component
{
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'id';
    
    public $sortDirection = 'desc';
    
    public function getAreaofinterestProperty()
    {
        return AreaOfInterest::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
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
        $areaofinterests = AreaOfInterest::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.areaofinterest-index', [
            'areaofinterests' => $areaofinterests
        ]);
    }
    public function deleteRecords()
    {
        AreaOfInterest::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    
    public function deleteRecord($areaofinterest_id)
    {
        $areaofinterest = AreaOfInterest::findOrFail($areaofinterest_id);
        $areaofinterest->delete();
        $this->checked = array_diff($this->checked, [
            $areaofinterest_id
        ]);
        session()->flash('info', 'Record deleted successfully');
    }
    
    public function exportSelected()
    {
        return (new AreaOfInterestExport($this->checked))->download('AreaofInterest.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->areaofinterest->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    
    public function isChecked($areaofinterest_id)
    {
        return in_array($areaofinterest_id, $this->checked);
    }
    
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
}
