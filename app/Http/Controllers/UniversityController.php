<?php

namespace App\Http\Controllers;


use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    //
    public function index()
    {
        return view('admin.university.index');
    }
    public function create()
    {
        return view('admin.university.create');
    }
    public function update($id)
    {
        return view('admin.university.update',['id'=>$id]);
    }
    public function view($id)
    {
        return view('admin.university.view',['id'=>$id]);
    }
}
