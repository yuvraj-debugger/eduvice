<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UniversityCampus;
use App\Models\University;
use App\Models\Course;

class UniversityView extends Component
{
    public $university_id;
    
    public function mount($university_id)
    {
        $this->university_id = $university_id;
    }
    
    public function render()
    {
        $university = University::with('universityCampus')->where('id',$this->university_id)->first();
        $university_course = Course::where('university_id',$this->university_id)->paginate(10);
        
        return view('livewire.university-view',compact('university','university_course'));
    }
}
