<?php

namespace App\Http\Livewire;

use App\Models\GlobalCourses;
use Livewire\Component;

class GlobalcoursesView extends Component
{
    public $globalcourse_id;
    
    public function mount($globalcourse_id)
    {
        $this->globalcourse_id = $globalcourse_id;
    }
    
    public function render()
    {
        $globalCourse = GlobalCourses::where('global_course.id',$this->globalcourse_id)->first();
        return view('livewire.globalcourses-view',compact('globalCourse'));
    }
}
