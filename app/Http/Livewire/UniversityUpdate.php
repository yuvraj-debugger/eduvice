<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\University;
use App\Models\UniversityCampus;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UniversityUpdate extends Component
{
    use WithFileUploads;

    public $name, $address, $city, $country, $province, $about, $status, $pincode;

    public $campus_name, $campus_address,$logo_s3;

    public $logo;

    public $logo_image;

    public $university_id;

    public $placement_website, $placement_email, $placement_contact_number, $placement_contact_person, $admission_website, $admission_email;

    public $admission_contact_number, $admission_contact_person;

    public $updateMode = false;

    public $campus_id = [];

    public $inputs = [];

    public $i = 1;

    public $delete_campus = [];

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
        $this->campus_id[$i] = '-';
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        $delete_campus[$i] = ! empty($i) ? $this->campus_id[$i] : '';
        foreach ($delete_campus as $deleteMultiple) {
            $campusIds = ! empty($deleteMultiple) ? $deleteMultiple : '';
        }
        $campusMultiple = UniversityCampus::where('id', $campusIds)->first();

        if (! empty($campusMultiple)) {
            $campusMultiple->delete();
        } else {
            unset($this->campus_name[$i]);
            unset($this->campus_address[$i]);
            unset($this->campus_id[$i]);
            unset($this->inputs[$i]);
        }
    }

    public function mount($university_id)
    {
        $this->university_id = $university_id;
        $universities = University::where('id', $this->university_id)->first();
        $universitiesCampus = UniversityCampus::where('university_id', $universities->id)->get();
        $this->name = $universities->name;
        $this->address = $universities->address;
        $this->city = $universities->city;
        $this->province = $universities->province;
        $this->country = $universities->country;
        $this->admission_contact_person = $universities->admission_contact_person;
        $this->admission_contact_number = $universities->admission_contact_number;
        $this->admission_email = $universities->admission_email;
        $this->admission_website = $universities->admission_website;
        $this->placement_contact_person = $universities->placement_contact_person;
        $this->placement_contact_number = $universities->placement_contact_number;
        $this->placement_email = $universities->placement_email;
        $this->placement_website = $universities->placement_website;
        $this->logo_image = $universities->about;
        $this->logo = "";
        
        $this->logo_s3 = $universities->logo;
        $this->status = $universities->status;

        for ($j = 0; $j < count($universitiesCampus); ++ $j) {
            array_push($this->inputs, $j);

            if (! empty($universitiesCampus[$j])) {
                if (isset($universitiesCampus[$j]->name)) {
                    $this->campus_name[$j] = $universitiesCampus[$j]->name;
                    $this->campus_address[$j] = $universitiesCampus[$j]->address;
                    $this->campus_id[$j] = $universitiesCampus[$j]->id;
                }
            }
        }
        $this->i = ++ $j;
    }

    public function store()
    {
        $s3 = Storage::disk('s3');
        $logo = $this->logo_s3;
        if (! empty($this->logo)) {
            $fileName = $this->logo->getClientOriginalName();
            $logo = $s3->put($fileName, $this->logo);
            $logo = Storage::disk('s3')->url($logo);
        }
            University::where('id', $this->university_id)->update([
                'name' => $this->name,
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'province' => $this->province,
                'pincode' => $this->pincode,
                'about' => $this->about,
                'logo' => $logo,
                'status' => $this->status,
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
        if (! empty($campuses)) {
            foreach ($campuses as $key => $campus) {
                if (! empty($campus)) {
                    $universityCampus = UniversityCampus::where('id', $this->campus_id[$key])->first();

                    if (! empty($universityCampus)) {
                        $universityCampus = UniversityCampus::where('id', $this->campus_id[$key])->update([
                            'name' => $campus,
                            'address' => $this->campus_address[$key],
                            'university_id' => $this->university_id
                        ]);
                    } else {
                        $universityCampus = UniversityCampus::create([
                            'name' => $campus,
                            'address' => $this->campus_address[$key],
                            'university_id' => $this->university_id
                        ]);
                    }
                }
                ++ $j;
            }
        }

        return redirect(route('admin.university.index'))->with('success', 'University update successfully');
    }

    public function render()
    {
        $universityData = University::where('id', $this->university_id)->first();
        $universitiesCampus_data = UniversityCampus::where('university_id', $this->university_id)->first();
        return view('livewire.university-update', [
            'universitiesCampus_data' => $universitiesCampus_data,
            'universityData' => $universityData
        ]);
    }
}
