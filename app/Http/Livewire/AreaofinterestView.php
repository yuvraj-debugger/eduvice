<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AreaOfInterest;

class AreaofinterestView extends Component
{

    public $areaofinterest_id;

    public function mount($areaofinterest_id)
    {
        $this->areaofinterest_id = $areaofinterest_id;
    }

    public function render()
    {
        $areaofinterest = AreaOfInterest::where('id', $this->areaofinterest_id)->first();
        return view('livewire.areaofinterest-view',compact('areaofinterest'));
    }
}
