<?php


namespace App\Http\Controllers;

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaOfInterest;
use App\Models\GlobalCourses;



class GlobalCourseController extends BaseController
{
    
    public function globalCourse()
    {
            $success=GlobalCourses::all();
            return $this->sendResponse($success, 'All Global Course');
    }
    
}
