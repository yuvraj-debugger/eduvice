<?php

namespace App\Http\Controllers;


use App\Models\GlobalCourses;
use Illuminate\Http\Request;

class GlobalCoursesController extends Controller
{
    //
    public function index()
    {
        return view('admin.globalcourses.index');
    }
    public function create()
    {
        return view('admin.globalcourses.create');
    }
    public function update($id)
    {
        return view('admin.globalcourses.update',['id'=>$id]);
    }
    public function view($id)
    {
        return view('admin.globalcourses.view',['id'=>$id]);
    }
}
