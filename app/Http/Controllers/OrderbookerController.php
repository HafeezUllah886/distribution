<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\orderbooker;
use Illuminate\Http\Request;

class OrderbookerController extends Controller
{
    public function index()
    {
        $orderbookers = orderbooker::all();
        return view('orderbooker.index', compact('orderbookers'));
    }

    public function store(request $req)
    {
        $check = orderbooker::where('name', $req->name)->count();
        if($check > 0)
        {
            return back()->with('error', 'Orderbooker Already Existing');
        }

        orderbooker::create($req->all());

        return back()->with('success', 'Orderbooker Created');
    }

    public function update(request $req)
    {
        $check = orderbooker::where('name', $req->name)
        ->where('id', '!=', $req->id)
        ->count();
        if($check > 0)
        {
            return back()->with('error', 'Orderbooker Already Existing');
        }

        orderbooker::find($req->id)
        ->update($req->all());
        return back()->with('success', 'Orderbooker Created');
    }
}
