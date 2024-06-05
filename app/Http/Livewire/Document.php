<?php

namespace App\Http\Livewire;

use App\Models\UserDocument;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Exports\DocumentExport;

class Document extends Component
{
    
    
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'id';
    
    public $sortDirection = 'DESC';
    
    public $message_filter=1;
    
    
    
    public function getUserDocumentProperty()
    {
       
        return UserDocument::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);        
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
        $document = UserDocument::search(trim($this->search));
        if($this->message_filter==2||$this->message_filter==3)
        {
            if($this->message_filter==3)
            {
                $message_id=Message::distinct()->select('document_id')->whereNull('is_read')->where('created_by','!=',Auth::user()->id)->get()->pluck('document_id')->toArray();
                
                $document=$document->whereIn('id',$message_id);
            }
            if($this->message_filter==2)
            {
                $message_id=Message::distinct()->select('document_id')->whereNull('is_read')->where('created_by','!=',Auth::user()->id)->get()->pluck('document_id')->toArray();
                
                $document=$document->whereNotIn('id',$message_id);
            }
        }
        $document = $document->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        
        return view('livewire.document',compact('document'));
    }
    public function deleteRecords()
    {
        UserDocument::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    public function deleteRecord($document_id)
    {
        $userDocument = UserDocument::findOrFail($document_id);
        $userDocument->delete();
        session()->flash('info', 'Record deleted successfully');
    }
    public function exportSelected()
    {
        return (new DocumentExport($this->checked))->download('UserDocuement.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->UserDocument->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    public function isChecked($document_id)
    {
        return in_array($document_id, $this->checked);
    }
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
}
