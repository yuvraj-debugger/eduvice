<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $appends = [
        'selected'
    ];

    protected $fillable = [
        'name',
        'phonecode',
        'shortname',
        'has_icon',
        'icon_svg',
        'icon_png',
        'is_selected'
    ];

    public function getSelectedAttribute()
    {
        $country = Preference::where('created_by', Auth::user()->id)->first();
        if ($country) {
            $country_array = json_decode($country->country_id,true);
            if (in_array($this->id, $country_array)) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}
