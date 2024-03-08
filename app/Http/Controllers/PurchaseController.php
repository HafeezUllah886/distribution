<?php

namespace App\Http\Controllers;

use App\Models\account;
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
        $accounts = account::where('category', 'Business')->get();
        $vendors = account::where('category', 'Vendor')->get();
     
        return view('purchase.create', compact('products', 'accounts', 'vendors'));
    }

    public function singleProduct($id)
    {
        return products::find($id);
    }
}
