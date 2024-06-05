<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\University;
use Illuminate\Support\Facades\Request;
use App\Models\UniversityCampus;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class UniversityCreate extends Component
{
    use WithFileUploads;

    public $name, $address, $city, $country, $province, $about, $status, $pincode,$logo;

    public $campus_name, $campus_address;

    public $placement_website, $placement_email, $placement_contact_number, $placement_contact_person, $admission_website, $admission_email;

    public $admission_contact_number, $admission_contact_person;

    public $updateMode = false;

    public $inputs = [];

    public $i = 1;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'country' => 'required',
        'province' => 'required',
        'pincode' => 'required',
        'status' => 'required',
        'placement_website' => 'required',
        'placement_email' => 'required',
        'placement_contact_number' => 'required',
        'placement_contact_person' => 'required',
        'admission_website' => 'required',
        'admission_email' => 'required',
        'admission_contact_number' => 'required',
        'admission_contact_person' => 'required'
    ];

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function store()
    {
        $s3 = Storage::disk('s3');
        $file = $this->logo;
        $fileName = ! empty($file) ? $file->getClientOriginalName() : '';
        $logo = $s3->put($fileName, $file);
        $logo = Storage::disk('s3')->url($logo);
        
        $this->validate();
        $university = University::create([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'province' => $this->province,
            'pincode' => $this->pincode,
            'about' => $this->about,
            'status' => $this->status,
            'logo'=>$logo,
            'placement_website' => $this->placement_website,
            'placement_email' => $this->placement_email,
            'placement_contact_person' => $this->placement_contact_person,
            'placement_contact_number' => $this->placement_contact_number,
            'admission_website' => $this->admission_website,
            'admission_email' => $this->admission_email,
            'admission_contact_number' => $this->admission_contact_number,
            'admission_contact_person' => $this->admission_contact_person
        ]);

        $campuses = $this->campus_name;
        $j = 0;
        foreach ($campuses as $campus) {
            if (! empty($campus) && ! empty($this->campus_address[$j])) {
                $universityCampus = UniversityCampus::create([
                    'name' => $campus,
                    'address' => $this->campus_address[$j],
                    'university_id' => $university->id
                ]);
            }
           
        }

        return redirect(route('admin.university.index'))->with('success', 'University added successfully');
    }

    private function resetInputFields()
    {
        $this->campus_name = '';
        $this->campus_address = '';
    }

    public function render()
    {
        return view('livewire.university-create');
    }
}
