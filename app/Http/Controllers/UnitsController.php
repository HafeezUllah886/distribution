<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\units;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitsController extends Controller
{
    public function index()
    {
        $units = units::all();
        return view('units.index', compact('units'));
    }

    public function store(request $req)
    {
        $check = units::where('name', $req->name)->count();
        if($check > 0)
        {
            return back()->with('error', 'Unit Already Existing');
        }

        units::create($req->all());

        return back()->with('success', 'Unit Created');
    }

    public function update(request $req)
    {
        $check = units::where('name', $req->name)
        ->where('id', '!=', $req->id)
        ->count();
        if($check > 0)
        {
            return back()->with('error', 'Unit Already Existing');
        }

        units::find($req->id)
        ->update($req->all());
        return back()->with('success', 'Unit Updated');
    }
}
