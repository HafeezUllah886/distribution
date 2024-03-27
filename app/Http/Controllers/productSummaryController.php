<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\purchase_details;
use App\Models\sale_details;
use App\Models\sale_return_details;
use App\Models\stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productSummaryController extends Controller
{
    public function index()
    {
        $topProducts = DB::table('products')
            ->select('products.desc', DB::raw('SUM(sale_details.qty) - SUM(sale_return_details.qty) AS total_sold'))
            ->leftJoin('sale_details', 'sale_details.productID', '=', 'products.id')
            ->leftJoin('sale_return_details', 'sale_return_details.productID', '=', 'products.id')
            ->groupBy('products.id', 'product.desc')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        $productNames = [];
        $totalSold = [];
        foreach ($topProducts as $product) {
            $productNames[] = $product->desc;
            $totalSold[] = $product->total_sold;
        }

        $products = products::all();
        foreach($products as $product)
        {
            $sales = sale_details::where('productID', $product->id)->get();
            $product->sale_qty = $sales->sum('qty');
            $product->sale_amount = $sales->sum('amount');

            $purchases = purchase_details::where('productID', $product->id)->get();
            $product->purchase_qty = $purchases->sum('qty');
            $product->purchase_amount = $purchases->sum('amount');

            $returns = sale_return_details::where('productID', $product->id)->get();
            $product->return_qty = $returns->sum('qty');
            $product->return_amount = $returns->sum('amount');

            $stock = stocks::where('productID', $product->id)->get();
            $product->stock = $stock->sum('cr') - $stock->sum('db');

        }

        return view('reports.productSummary.index', compact('productNames', 'totalSold', 'products'));
    }
}
