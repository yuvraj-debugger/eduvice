<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\API;

use App\Models\AreaOfInterest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class AddressController extends BaseController
{
    
    public function country()
    {
        
        $course = Course::select('countryName')->distinct()->get()->pluck('countryName')->toArray();
        $success['countryies']=Country::whereIn('name',$course)->get();
        $success['area_of_interest']=AreaOfInterest::all();
        $success['user']=Auth::user();
        return $this->sendResponse($success, 'All Countries, Area of Interest and User Details');
    }
    public function state($country_id)
    {
        $success['states']=State::where('country',$country_id)->get();
        
        return $this->sendResponse($success, 'All States');
    }
    public function city($state,$country)
    {
        $success['cities']=City::where('country',$country)->where('state',$state)->get();
        return $this->sendResponse($success, 'All Cities');
    }
    
}
