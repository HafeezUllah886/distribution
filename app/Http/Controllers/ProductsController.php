<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = products::all();
        return view('products.index',compact('products'));
    }

    public function store(request $req)
    {
        $check = products::where('desc', $req->desc)->count();
        if($check > 0)
        {
            return back()->with('error', 'Product already exists');
        }
        $products = products::create($req->all());
        return back()->with('success', 'Product Created');
    }

    public function update(request $req)
    {
        $check = products::where('desc', $req->desc)
        ->where('id', '!=', $req->id)
        ->count();
        if($check > 0)
        {
            return back()->with('error', 'Product already exists');
        }
        $products = products::find($req->id)->update($req->all());
        return back()->with('success', 'Product Updated');
    }
}
