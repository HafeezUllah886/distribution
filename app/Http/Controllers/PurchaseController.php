<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\products;
use App\Models\purchase;
use App\Models\purchase_details;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = purchase::orderBy('id', 'desc')->get();
        return view('purchase.index', compact('purchases'));
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

    public function store(Request $req)
    {
       
    $refID = getRef();

    $purchase = purchase::create(
        [
            'date'          => $req->date,
            'vendorID'      => $req->vendorID,
            'accountID'     => $req->accountID,
            'shippingCost'  => $req->shippingCost,
            'notes'         => $req->notes,
            'refID'         => $refID,
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
            $value          = $req->value[$key];
            $discount_per   = $req->discount_per[$key];
            $discount_val   = $req->discount_val[$key];
            $gst_per        = $req->gst_per[$key];
            $gst_val        = $req->gst_val[$key];
            $fst_per        = $req->fst_per[$key];
            $fst_val        = $req->fst_val[$key];
            $amount         = $req->amount[$key];
            $total         += $amount;
            purchase_details::create(
                [
                    'purchaseID'    => $purchase->id,
                    'productID'     => $productID,
                    'qty'           => $qty,
                    'price'         => $price,
                    'value'         => $value,
                    'discount_per'  => $discount_per,
                    'discount_val'  => $discount_val,
                    'gst_per'       => $gst_per,
                    'gst_val'       => $gst_val,
                    'fst_per'       => $fst_per,
                    'fst_val'       => $fst_val,
                    'amount'        => $amount,
                    'date'          => $req->date,
                    'refID'         => $refID,
                ]
            );

            createStock($productID, $req->date, $qty, 0, "Purchased in $purchase->id", $refID);
        }

        addTransaction($req->vendorID, $req->date, $total, $total, $refID, "Payment of Purchase ID $purchase->id");
        addTransaction($req->accountID, $req->date, 0, $total + $req->shippingCost, $refID, "Payment of Purchase ID $purchase->id");

        return redirect()->route('purchaseHistory')->with('success', 'Purchase Created');
    }

    public function show($id)
    {
        $purchase = purchase::findOrFail($id);
        return view('purchase.show', compact('purchase'));
    }
   
}
