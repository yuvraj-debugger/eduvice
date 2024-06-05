<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserDocument;
use App\Models\Message;
use App\Models\TeamUser;
use Illuminate\Support\Facades\Auth;

class DocumentMessage extends Component
{
    public $message,$document_id;
    
    
    protected $rules = [
        'message' => 'required',
    ];
    
    public function mount($document_id)
    {
        $this->document_id = $document_id;
        Message::where('document_id', $this->document_id)->where('created_by','!=', Auth::user()->id)->update([
            'is_read' => '1'
        ]);
    }
    
    public function render()
    {
        $document_id = UserDocument::where('id',$this->document_id)->first();
        $message_id = Message::where('document_id',$document_id->id)->get();
        return view('livewire.document-message',['document_id' => $document_id,'message_id'=>$message_id]);
    }
}
