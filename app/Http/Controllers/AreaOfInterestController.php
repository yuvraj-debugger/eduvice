<?php

namespace App\Http\Controllers;


use App\Models\AreaOfInterest;
use Illuminate\Http\Request;

class AreaOfInterestController extends Controller
{
    public function index()
    {
        return view('admin.areaofinterest.index');
    }
    public function create()
    {
        return view('admin.areaofinterest.create');
    }
    public function update($id)
    {
        return view('admin.areaofinterest.update',['id'=>$id]);
    }
    public function view($id)
    {
        return view('admin.areaofinterest.view',['id'=>$id]);
    }
}
