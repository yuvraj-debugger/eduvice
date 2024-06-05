<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaOfInterest;
use Illuminate\Support\Facades\Auth;

class AreaofinterestCreate extends Component
{
    public $title;
    
    protected $rules = [
        'title' =>'required|regex:/^[\pL\s\-]+$/u|',
    ];
    
    public function store()
    {
        $this->validate();
        
        // Execution doesn't reach here if validation fails.
        
        AreaOfInterest::create([
            'title' => $this->title,
            'created_by' => Auth::user()->id
        ]);
       return redirect(route('admin.areaofinterest.index'))->with('success','Area of interest added successfully');
    }
    public function render()
    {
        return view('livewire.areaofinterest-create');
    }
}
