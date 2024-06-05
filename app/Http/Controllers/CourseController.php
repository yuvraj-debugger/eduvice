<?php

namespace App\Http\Controllers;


use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.index');
    }
    public function create()
    {
        return view('admin.manage.create');
    }
    public function update($id)
    {
        return view('admin.manage.update',['id'=>$id]);
    }
    public function view($id)
    {
        return view('admin.manage.view',['id'=>$id]);
    }
    
}
