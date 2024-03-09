<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\stocks;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index()
    {
        $products = products::all();
        foreach($products as $product)
        {
            $cr = stocks::where('productID', $product->id)->sum('cr');
            $db = stocks::where('productID', $product->id)->sum('db');

            $product->stock = $cr - $db;
        }

        return view('stock.index', compact('products'));
    }

    public function details($id, $start, $end)
    {
        $product = products::find($id);
        $stocks = stocks::where('productID', $id)
        ->whereBetween('date', [$start, $end])
        ->get();

        $pre_cr = stocks::where('productID', $id)->whereDate('date', '<', $start)->sum('cr');
        $pre_db = stocks::where('productID', $id)->whereDate('date', '<', $start)->sum('db');
        $opening_balance = $pre_cr - $pre_db;

        $cur_cr = stocks::where('productID', $id)->whereDate('date', '<=', $end)->sum('cr');
        $cur_db = stocks::where('productID', $id)->whereDate('date', '<=', $end)->sum('db');
        $closing_balance = $cur_cr - $cur_db;

        $balance = $opening_balance;
        foreach($stocks as $stock)
        {
            $balance += $stock->cr;
            $balance -= $stock->db;
            $stock->balance = $balance;
        }

        return view('stock.details', compact('stocks', 'start', 'end', 'opening_balance', 'closing_balance', 'product'));
    }
}
