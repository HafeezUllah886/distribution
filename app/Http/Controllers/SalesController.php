<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\products;
use App\Models\sales;
use App\Models\stocks;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = sales::orderBy('id', 'desc')->get();
        return view('sale.index', compact('sales'));
    }

    public function create()
    {
        $products = products::all();
        foreach($products as $product)
        {
            $cr = stocks::where('productID', $product->id)->sum('cr');
            $db = stocks::where('productID', $product->id)->sum('db');
            $product->stock = $cr - $db;
        }
        $accounts = account::where('category', 'Business')->get();
        $customers = account::where('category', 'Customer')->get();
     
        return view('sale.create', compact('products', 'accounts', 'customers'));
    }

}
