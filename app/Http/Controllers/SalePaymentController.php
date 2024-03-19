<?php

namespace App\Http\Controllers;

use App\Models\sale_payment;
use App\Models\sales;
use App\Models\transactions;
use Illuminate\Http\Request;

class SalePaymentController extends Controller
{
    public function payments($id)
    {
        
        $payments = sale_payment::with('account')->where('salesID', $id)->get();
       
        return response()->json($payments);
    }

    public function delete($ref)
    {
        transactions::where('refID', $ref)->delete();
        sale_payment::where('refID', $ref)->delete();
    }

    public function store(request $req)
    {
        $ref = getRef();
        $sale = sales::find($req->salesID);
        sale_payment::create(
            [
                'salesID'    => $req->salesID,
                'accountID'  => $req->accountID,
                'date'       => $req->date,
                'amount'     => $req->amount,
                'notes'      => $req->notes,
                'refID'      => $ref
            ]
        );
        addTransaction($sale->customerID, $req->date, 0, $req->amount, $ref, "Payment of Sale # $sale->id");
        addTransaction($req->accountID, $req->date, $req->amount, 0, $ref, "Payment of Sale # $sale->id");

        return back()->with("success", "Payment Stored");
    }
}
