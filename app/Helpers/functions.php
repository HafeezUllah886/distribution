<?php

use App\Models\account;
use App\Models\expense;
use App\Models\products;
use App\Models\purchase_details;
use App\Models\reference;
use App\Models\sale_details;
use App\Models\stocks;
use App\Models\todo;
use App\Models\transactions;
use Carbon\Carbon;

function getRef()
{
    $ref = reference::first();
    if ($ref) {
        $ref->ref = $ref->ref + 1;
    } else {
        $ref = new reference();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}


function addTransaction($accountID, $date, $credit, $debt, $refID, $desc)
{
    transactions::create([
        'accountID' => $accountID,
        'date' => $date,
        'cr' => $credit,
        'db' => $debt,
        'refID' => $refID,
        'notes' => $desc,
    ]);
}

function createStock($productID, $date, $credit, $debt, $notes, $refID)
{
    stocks::create([
        'productID' => $productID,
        'date' => $date,
        'cr' => $credit,
        'db' => $debt,
        'notes' => $notes,
        'refID' => $refID,
    ]);
}

function getAccountBalance($id)
{
    $cr = transactions::where('accountID', $id)->sum('cr');
    $db = transactions::where('accountID', $id)->sum('db');

    return $cr - $db;
}

function getInitials($string)
{
    $words = explode(' ', $string);
    $initials = '';

    if (count($words) === 1) {
        $initials = substr($words[0], 0, 3);
    } else {
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        // Limit the initials to 3 characters
        $initials = substr($initials, 0, 3);
    }

    return $initials;
}

function firstDayOfMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();

    return $startOfMonth->format('Y-m-d');
}
function lastDayOfMonth()
{

    $endOfMonth = Carbon::now()->endOfMonth();

    return $endOfMonth->format('Y-m-d');
}

function customer_dues()
{
    $customers = account::where('category', 'Customer')->get();
    $balance = 0;
    foreach($customers as $customer)
    {
        $cr = transactions::where('accountID', $customer->id)->sum('cr');
        $db = transactions::where('accountID', $customer->id)->sum('db');
        $balance += $cr - $db;
    }

    return number_format($balance,0);
}

function stock($type)
{
    $products = products::all();
    $total_stock = 0;
    $total_value = 0;
    foreach($products as $product)
    {
        $cr = stocks::where('productID', $product->id)->sum('cr');
        $db = stocks::where('productID', $product->id)->sum('db');
        $stock = $cr - $db;
        $total_stock += $stock;

        $purchase = purchase_details::where('productID', $product->id)
        ->orderBy('id', 'desc')
        ->take(5)->get();

        $amount = $purchase->sum('amount');
        $qty = $purchase->sum('qty');
        if($amount < 1)
        {
            $total_value += 0;
        }
        else{
            $price = $amount / $qty;
            $value = $price * $stock;
            $total_value += $value;
        }
    }

    if($type == 'totalStock'){
        return number_format($total_stock,0);
    }

    if($type == 'totalValue'){
        return number_format($total_value,0);
    }
}

function expenseThisMonth()
{
    $start = firstDayOfMonth();
    $end = lastDayOfMonth();

    $expense = expense::whereBetween('date', [$start, $end])->sum('amount');

    return number_format($expense,0);
}

function profit()
    {
        $products = products::all();
        $netProfit = 0;
        foreach($products as $product)
        {
            ///////////Purchase Details //////////////
            $purchase = purchase_details::where('productID', $product->id)->get();
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

            $sale = sale_details::where('productID', $product->id)->get();
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
            $product->profitPerProduct = $product->avgSalePrice - $product->avgPurchasePrice;
            $product->subProfit = $product->profitPerProduct * $product->totalSold; 

            $netProfit += $product->subProfit;
        }
        $expenses = expense::sum('amount');
        $netProfit = $netProfit - $expenses;
        return number_format($netProfit,0);
    }

    function reminder()
    {
        $current_date = now();

        $todos = todo::where('status', '!=', 'Done')->where('due', '<', $current_date)->count();

        return $todos;
    }

