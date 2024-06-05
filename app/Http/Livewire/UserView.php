<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserDocument;

class UserView extends Component
{
    public $user_id;
    
    public function mount($userid)
    {
        $this->user_id=$userid;
    }
    public function render()
    {
        $user=User::where('id',$this->user_id)->get()->first();
        $userDocument = UserDocument::where('created_by',$this->user_id)->get();
        
        return view('livewire.user-view',['user'=>$user,'userDocument'=>$userDocument]);
    }
}
