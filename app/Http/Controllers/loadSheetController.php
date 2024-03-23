<?php

namespace App\Http\Controllers;

use App\Models\orderbooker;
use App\Models\sales;
use App\Models\salesman;
use Illuminate\Http\Request;

class loadSheetController extends Controller
{
    public function index()
    {
        $orderbookers = orderbooker::all();

        return view('reports.loadsheet.index', compact('orderbookers'));
    }

    public function print(request $req)
    {
        $sales = sales::where('date', $req->date)
        ->where('orderbookerID', $req->orderbooker)
        ->with('details') // Eager load sale details
        ->get();

        if ($sales->isEmpty()) {
            return null;
        }
        
        $salesData = [
            'sale_info' => $sales->map->toArray(), // Sale details for all sales
            'sale_details' => [], // Initialize as an empty array
            'total_sale_amount' => 0,
        ];
    
        $allProducts = []; // Store product details with accumulated quantities and amounts
    
        foreach ($sales as $sale) {
            $productSales = $sale->details->groupBy('productID');
    
            foreach ($productSales as $productID => $saleDetails) {
                $totalQty = $saleDetails->sum('qty');
                $totalAmount = $saleDetails->sum('amount');
    
                // Check if product exists in $allProducts
                if (!isset($allProducts[$productID])) {
                    $product = $saleDetails->first()->product; // Access product details
                    $allProducts[$productID] = [
                    'productID' => $productID,
                    'description' => $product->desc,
                    'code' => $product->code,
                    'pack_size' => $product->p_size,
                    'total_qty' => 0,
                    'total_amount' => 0,
                    ];
                }
    
                $allProducts[$productID]['total_qty'] += $totalQty;
                $allProducts[$productID]['total_amount'] += $totalAmount;
            }
    
            $salesData['total_sale_amount'] += $sale->payments->sum('amount');
            $salesData['orderbooker'] = $sale->orderbooker->name;
            $salesData['date'] = $sale->date;
        }
    
        $salesData['sale_details'] = array_values($allProducts); // Convert to a plain array
    
        return view('reports.loadsheet.show', compact('salesData'));
    }
}
