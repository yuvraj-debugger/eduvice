<?php
namespace App\Http\Livewire;

use App\Models\AreaOfInterest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AreaofinterestUpdate extends Component
{

    public $title;

    public $areaofinterest_id;

    protected $rules = [
        'title' => 'required|regex:/^[\pL\s\-]+$/u|'
    ];

    public function mount($areaofinterest_id)
    {
        $this->areaofinterest_id = $areaofinterest_id;
        $areaofinterest = AreaOfInterest::where('id', $this->areaofinterest_id)->first();
        $this->title = $areaofinterest->title;
    }

    public function store()
    {
        $this->validate();

        AreaOfInterest::where('id', $this->areaofinterest_id)->update([
            'title' => $this->title,
            'created_by' => Auth::user()->id
        ]);

        return redirect(route('admin.areaofinterest.index'))->with('success', 'Area of interest updated successfully');
    }

    public function render()
    {
        $areaofinterest = AreaOfInterest::where('id', $this->areaofinterest_id)->first();
        return view('livewire.areaofinterest-update', [
            'areaofinterest' => $areaofinterest
        ]);
    }
}
