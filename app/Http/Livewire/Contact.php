<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Contact extends Component
{
    public $captcha = 0;
    public function render()
    {
        return view('livewire.contact');
    }
    
    
    public function updatedCaptcha($token)
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret=' . env('CAPTCHA_SECRET_KEY') . '&response=' . $token);
        $this->captcha = $response->json()['score'];
        
        if (!$this->captcha > .3) {
            $this->store();
        } else {
            return session()->flash('success', 'Google thinks you are a bot, please refresh and try again');
        }
        
    }
    public function store()
    {
        // store the contact information
    }
}
