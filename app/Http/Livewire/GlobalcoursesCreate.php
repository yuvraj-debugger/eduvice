<?php
namespace App\Http\Livewire;

use App\Models\AreaOfInterest;
use App\Models\GlobalCourses;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GlobalcoursesCreate extends Component
{

    public $title;

    public $mark_grade;

    protected $rules = [
        'title' => 'required',
        'mark_grade'=>'required'
    ];

    protected $messages = [
        'mark_grade.required' => 'High Education is required',
    ];

    public function store()
    {
        $this->validate();

        $global = GlobalCourses::create([
            'title' => $this->title,
            'mark_grade' => $this->mark_grade,
            'created_by' => Auth::user()->id
        ]);

        return redirect(route('admin.globalcourses.index'))->with('success', 'Global Courses added successfully');
    }

    public function render()
    {
        $areaofinterests = AreaOfInterest::all();
        return view('livewire.globalcourses-create', compact('areaofinterests'));
    }
}
