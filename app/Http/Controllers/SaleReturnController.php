<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\orderbooker;
use App\Models\products;
use App\Models\sale_details;
use App\Models\sale_return;
use App\Models\sale_return_details;
use App\Models\stocks;
use App\Models\transactions;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function index()
    {
        $returns = sale_return::all();

        return view('sale_return.index', compact('returns'));
    }

    public function create()
    {
        $products = products::all();
        $accounts = account::where('category', 'Business')->get();
        $customers = account::where('category', 'Customer')->get();
        $orderbookers = orderbooker::all();

        return view('sale_return.create', compact('products', 'accounts', 'customers', 'orderbookers'));
    }
    public function singleProduct($id)
    {
        $product = products::find($id);
        $sale = sale_details::where('productID', $product->id)
        ->orderBy('id', 'desc')
        ->take(2)
        ->get();
        $sumOfAmount = $sale->sum('amount');
        $sumOfQty = $sale->sum('qty');
        $sumOfBonus = $sale->sum('bonus');
        
        if($sumOfAmount > 0)
        {
            $avgSalePrice = $sumOfAmount / ($sumOfQty - $sumOfBonus);
        }
        else
        {
            $avgSalePrice = 0;
        }
        
        $product->price = number_format($avgSalePrice,2);
        return $product;
    }

    public function store(request $req)
    {
        $ref = getRef();

    $return = sale_return::create(
        [
            'date'          => $req->date,
            'customerID'    => $req->customerID,
            'accountID'     => $req->accountID,
            'orderbookerID' => $req->orderbookerID,
            'refID'         => $ref,
        ]
    );
        $products = $req->productID;
        $total = 0;
        foreach($products as $key => $product)
        {
            $total += $req->amount[$key];
            $refID = getRef();
            $id     = $req->productID[$key];
            $qty    = $req->qty[$key];
            $price  = $req->price[$key];
            $amount = $req->amount[$key];
            $reason = $req->reason[$key];
            sale_return_details::create(
                [
                    'salereturnID'  => $return->id,
                    'productID'     => $id,
                    'qty'           => $qty,
                    'price'         => $price,
                    'amount'        => $amount,
                    'reason'        => $reason,
                    'date'          => $req->date,
                    'refID'         => $refID,
                ]
            );
            createStock($id, $req->date, $qty, 0, "Returned with reason: $reason", $refID);
        }
        addTransaction($req->accountID, $req->date, 0, $total, $ref, "Payment of Return");

        return redirect()->route('saleReturns')->with('success', 'Return Created');
    }

    public function show($id)
    {
        $return = sale_return::with('account', 'customer', 'orderbooker', 'details')->find($id);
        return view('sale_return.show', compact('return'));
    }

    public function delete($id)
    {
        $return = sale_return::find($id);
        foreach($return->details as $product)
        {
            stocks::where('refID', $product->refID)->delete();
            $product->delete();
        }
        transactions::where('refID', $return->refID)->delete();
        $return->delete();

        return redirect()->route('saleReturns')->with('error', 'Sale Return Deleted');
    }
}
