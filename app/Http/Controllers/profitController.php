<?php

namespace App\Http\Controllers;

use App\Models\expense;
use App\Models\products;
use App\Models\purchase_details;
use App\Models\sale_details;
use App\Models\sale_return_details;
use Illuminate\Http\Request;

class profitController extends Controller
{
    public function index()
    {
        return view('reports.profit.index');
    }

    public function show(request $req)
    {
        $start = $req->start;
        $end = $req->end;
        $products = products::all();
        foreach($products as $product)
        {
            ///////////Purchase Details //////////////
            $purchase = purchase_details::where('productID', $product->id)
            ->whereBetween('date', [$start, $end])
            ->get();
            $sumOfAmount = $purchase->sum('amount');
            $sumOfQty = $purchase->sum('qty');
            $sumOfBonus = $purchase->sum('bonus');
            if($purchase->count() < 1)
            {
                $purchase = purchase_details::where('productID', $product->id)
                ->orderBy('id', 'desc')
                ->first();

                $sumOfAmount = $purchase->amount ?? 0;
                $sumOfQty = $purchase->qty ?? 0;
                $sumOfBonus = $purchase->bonus ?? 0;
            }
            
            if($sumOfAmount > 0)
            {
                $avgPurchasePrice = $sumOfAmount / ($sumOfQty - $sumOfBonus);
            }
            else
            {
                $avgPurchasePrice = 0;
            }
            
            $product->avgPurchasePrice = $avgPurchasePrice;

            ///////////Sale Details //////////////

            $sale = sale_details::where('productID', $product->id)
            ->whereBetween('date', [$start, $end])
            ->get();
            $sumOfAmount = $sale->sum('amount');
            $sumOfQty = $sale->sum('qty');
            $sumOfBonus = $sale->sum('bonus');
            if($sale->count() < 1)
            {
                $sale = sale_details::where('productID', $product->id)
                ->orderBy('id', 'desc')
                ->first();

                $sumOfAmount = $sale->amount ?? 0;
                $sumOfQty = $sale->qty ?? 0;
                $sumOfBonus = $sale->bonus ?? 0;
            }
            
            if($sumOfAmount > 0)
            {
                $avgSalePrice = $sumOfAmount / ($sumOfQty - $sumOfBonus);
            }
            else
            {
                $avgSalePrice = 0;
            }
            
            $product->avgSalePrice = $avgSalePrice;
            $product->totalSold = $sumOfQty - $sumOfBonus;
            ///////////Return Details //////////////

            $return = sale_return_details::where('productID', $product->id)
            ->whereBetween('date', [$start, $end])
            ->get();
            $returnQty = $return->sum('qty');
            
            $product->return = $returnQty;
            $product->profitPerProduct = $product->avgSalePrice - $product->avgPurchasePrice;
            $product->subProfit = $product->profitPerProduct * ($product->totalSold - $returnQty); 
        }
        $expenses = expense::whereBetween('date', [$start, $end])->sum('amount');

        return view('reports.profit.show', compact('products', 'start', 'end', 'expenses'));
    }
}
