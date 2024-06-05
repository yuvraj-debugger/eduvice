<?php


namespace App\Http\Controllers;

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaOfInterest;



class AreaOfInterestController extends BaseController
{
    
    public function areaInterest(Request $request)
    {
            $success['area_of_interest']=AreaOfInterest::all();
            return $this->sendResponse($success, 'All Area Of Interest');
            
    }
    
}















?>