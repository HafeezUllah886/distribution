<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\salesman;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    public function index()
    {
        $salesmans = salesman::all();
        return view('salesman.index', compact('salesmans'));
    }

    public function store(request $req)
    {
        $check = salesman::where('name', $req->name)->count();
        if($check > 0)
        {
            return back()->with('error', 'Salesman Already Existing');
        }

        salesman::create($req->all());

        return back()->with('success', 'Salesman Created');
    }

    public function update(request $req)
    {

        $check = salesman::where('name', $req->name)
        ->where('id', '!=', $req->id)
        ->count();
        if($check > 0)
        {
            return back()->with('error', 'Salesman Already Existing');
        }

        salesman::find($req->id)
        ->update($req->all());
        return back()->with('success', 'Salesman Created');
    }
}
