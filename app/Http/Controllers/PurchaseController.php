<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\products;
use App\Models\purchase;
use App\Models\purchase_details;
use App\Models\stocks;
use App\Models\transactions;
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
       
    $ref = getRef();

    $purchase = purchase::create(
        [
            'date'          => $req->date,
            'vendorID'      => $req->vendorID,
            'accountID'     => $req->accountID,
            'shippingCost'  => $req->shippingCost,
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

            $dist_per       = $req->dist_per[$key];
            $dist_val       = $req->dist_val[$key];

            $ws_per         = $req->ws_per[$key];
            $ws_val         = $req->ws_val[$key];

            $sch_per        = $req->sch_per[$key];
            $sch_val        = $req->sch_val[$key];

            $gross          = $req->gross[$key];

            $gst_per        = $req->gst_per[$key];
            $gst_val        = $req->gst_val[$key];

            $mrp_per        = $req->mrp_per[$key];
            $mrp_val        = $req->mrp_val[$key];

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

                    'dist_per'      => $dist_per,
                    'dist_val'      => $dist_val,

                    'ws_per'        => $ws_per,
                    'ws_val'        => $ws_val,

                    'sch_per'       => $sch_per,
                    'sch_val'       => $sch_val,

                    'gross'         => $gross,

                    'gst_per'       => $gst_per,
                    'gst_val'       => $gst_val,

                    'mrp_per'       => $mrp_per,
                    'mrp_val'       => $mrp_val,

                    'fst_per'       => $fst_per,
                    'fst_val'       => $fst_val,

                    'amount'        => $amount,
                    'date'          => $req->date,
                    'refID'         => $refID,
                ]
            );

            createStock($productID, $req->date, $qty, 0, "Purchased in $purchase->id", $refID);
        }

        addTransaction($req->vendorID, $req->date, $total, $total, $ref, "Payment of Purchase ID $purchase->id");
        addTransaction($req->accountID, $req->date, 0, $total + $req->shippingCost, $ref, "Payment of Purchase ID $purchase->id");

        return redirect()->route('purchaseHistory')->with('success', 'Purchase Created');
    }

    public function show($id)
    {
        $purchase = purchase::findOrFail($id);
        return view('purchase.show', compact('purchase'));
    }

    public function delete($id)
    {
        $purchase = purchase::findOrFail($id);
        foreach($purchase->details as $item)
        {
            stocks::where('refID', $item->refID)->delete();
            
            purchase_details::where('refID', $item->refID)->delete();
        }
        transactions::where('refID', $purchase->refID)->delete();
        $purchase->delete();

        return redirect()->route('purchaseHistory')->with("error", "Purchase Deleted");
    }
   
}
