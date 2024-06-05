<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {        
        return view('admin.users.index');
    }
    public function view($id)
    {
        return view('admin.users.view',['id'=>$id]);
    }
    
   
}
