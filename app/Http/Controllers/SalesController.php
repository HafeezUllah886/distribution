<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\products;
use App\Models\sale_details;
use App\Models\sale_payment;
use App\Models\sales;
use App\Models\stocks;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = sales::orderBy('id', 'desc')->get();
        $customers = account::where('category', 'Customer')->get();
        return view('sale.index', compact('sales', 'customers'));
    }

    public function create(request $req)
    {
        $products = products::all();
        foreach($products as $product)
        {
            $cr = stocks::where('productID', $product->id)->sum('cr');
            $db = stocks::where('productID', $product->id)->sum('db');
            $product->stock = $cr - $db;
        }
        $accounts = account::where('category', 'Business')->get();
        $customer = account::findOrFail($req->customer);
     
        return view('sale.create', compact('products', 'accounts', 'customer'));
    }

    public function singleProduct($id, $customer)
    {
        $customer = account::find($customer);
        $product = products::find($id);
        $cr = stocks::where('productID', $id)->sum('cr');
        $db = stocks::where('productID', $id)->sum('db');
        $product->stock = $cr - $db;
        return response()->json(
            [
                'product' => $product,
                'customer' => $customer
            ]
        );
    }

    public function store(Request $req)
    {
       
    $ref = getRef();

    $sale = sales::create(
        [
            'date'          => $req->date,
            'customerID'    => $req->customerID,
            'cell'          => $req->cell,
            'sign'          => $req->sign,
            'notes'         => $req->notes,
            'refID'         => $ref,
        ]
    );
        $products = $req->productID;
        $total = 0;
        foreach($products as $key => $product)
        {
            $refID          = getRef();
            $productID      = $req->productID[$key];
            $qty            = $req->qty[$key];
            $price          = $req->price[$key];

            $rt_per         = $req->rt_per[$key];
            $rt_val         = $req->rt_val[$key];

            $ws_per         = $req->ws_per[$key];
            $ws_val         = $req->ws_val[$key];

            $slb_per        = $req->slb_per[$key];
            $slb_val        = $req->slb_val[$key];

            $bonus          = $req->bonus[$key];
            
            $deal_per       = $req->deal_per[$key];
            $deal_val       = $req->deal_val[$key];

            $gross          = $req->gross[$key];

            $gst_per        = $req->gst_per[$key];
            $gst_val        = $req->gst_val[$key];

            $mrp_per        = $req->mrp_per[$key];
            $mrp_val        = $req->mrp_val[$key];

            $fst_per        = $req->fst_per[$key];
            $fst_val        = $req->fst_val[$key];

            $amount         = $req->amount[$key];
            $total         += $amount;
            sale_details::create(
                [
                    'salesID'       => $sale->id,
                    'productID'     => $productID,
                    'qty'           => $qty,
                    'price'         => $price,

                    'rt_per'        => $rt_per,
                    'rt_val'        => $rt_val,

                    'ws_per'        => $ws_per,
                    'ws_val'        => $ws_val,

                    'slb_per'       => $slb_per,
                    'slb_val'       => $slb_val,

                    'bonus'         => $bonus,

                    'deal_per'      => $deal_per,
                    'deal_val'      => $deal_val,

                    'gross'         => $gross,

                    'gst_per'       => $gst_per,
                    'gst_val'       => $gst_val,

                    'mrp_per'       => $mrp_per,
                    'mrp_val'       => $mrp_val,

                    'fst_per'       => $fst_per,
                    'fst_val'       => $fst_val,

                    'amount'        => $amount,
                    'unit_price'    => $amount/$qty,
                    'date'          => $req->date,
                    'refID'         => $refID,
                ]
            );

            createStock($productID, $req->date, 0, $qty, "Sold in Bill # $sale->id", $refID);
        }
        addTransaction($req->customerID, $req->date, $total, 0, $ref, "Pending of Sale # $sale->id");

        if($req->payment == 1)
        {
            sale_payment::create(
                [
                    'salesID'    => $sale->id,
                    'accountID'  => $req->accountID,
                    'date'       => $req->date,
                    'amount'     => $total,
                    'notes'      => 'Payment Received',
                    'refID'      => $ref
                ]
            );
            addTransaction($req->customerID, $req->date, 0, $total, $ref, "Payment of Sale # $sale->id");
            addTransaction($req->accountID, $req->date, $total, 0, $ref, "Payment of Sale # $sale->id");
        }

        return redirect()->route('saleHistory')->with('success', 'Sale Created');
    }

    public function show($id)
    {
        $sale = sales::findOrFail($id);
        return view('sale.show', compact('sale'));
    }

}
