<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
       
        return view('purchase.index');
    }

    public function create()
    {
        $products = products::all();
        return view('purchase.create', compact('products'));
    }

    public function singleProduct($id)
    {
        return products::find($id);
    }
}
