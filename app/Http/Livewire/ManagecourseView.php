<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;

class ManagecourseView extends Component
{
    
    public $course_id;
    
    public function mount($course_id)
    {
        $this->course_id = $course_id;
    }
    
    
    public function render()
    {
        $manageCourse = Course::where('id',$this->course_id)->first();
        return view('livewire.managecourse-view',compact('manageCourse'));
    }
}
