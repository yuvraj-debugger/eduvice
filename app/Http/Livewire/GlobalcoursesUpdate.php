<?php
namespace App\Http\Livewire;

use App\Models\AreaOfInterest;
use App\Models\GlobalCourses;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GlobalcoursesUpdate extends Component
{

    public $title, $globalcourses_id;
    public $mark_grade;
    protected $rules = [
        'title' => 'required',
        'mark_grade' => 'required',
    ];
    
    public function mount($globalcourses_id)
    {
        $this->globalcourses_id = $globalcourses_id;
        $globalcourses = GlobalCourses::where('id', $this->globalcourses_id)->first();
        $this->title=$globalcourses->title;
        $this->mark_grade = $globalcourses->mark_grade;
    }
    
    public function store()
    {
        $this->validate();
        GlobalCourses::where('id',$this->globalcourses_id)->update([
            'title' => $this->title,
            'mark_grade'=> $this->mark_grade,
            'created_by' => Auth::user()->id
        ]);
        
        return redirect(route('admin.globalcourses.index'))->with('success', 'Global Course updated successfully');
    }
    
    
    public function render()
    {
        $globalCourse = GlobalCourses::where('id',$this->globalcourses_id)->first();
        $areaofinterest = AreaOfInterest::all();
        return view('livewire.globalcourses-update',['areaofinterests'=>$areaofinterest,'globalCourse'=>$globalCourse]);
    }
}
