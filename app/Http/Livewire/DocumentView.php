<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserDocument;
use App\Models\Message;

class DocumentView extends Component
{
    
    public $document_id;
    
    public function mount($document_id)
    {
        $this->document_id = $document_id;
    }
    
    public function render()
    {
        $userDocument = UserDocument::where('id', $this->document_id)->first();
        $message_id = Message::where('document_id',$this->document_id)->get();
        $document_id = UserDocument::where('id',$this->document_id)->first();
        return view('livewire.document-view',compact('userDocument','message_id','document_id'));
    }
    
}
