<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\depositWithdraw;
use App\Models\transactions;
use Illuminate\Http\Request;

class DepositWithdrawController extends Controller
{
    public function index()
    {
        $accounts = account::where('status', 'Active')->get();
        $items = depositWithdraw::all();
        return view('account.deposit_withdraw.index', compact('items', 'accounts'));
    }

    public function store(request $req)
    {

        $ref = getRef();
        $req->merge(['refID' => $ref]);

        depositWithdraw::create($req->all());
        if($req->type == 'Deposit')
        {
            addTransaction($req->accountID, $req->date, $req->amount, 0, $ref, $req->notes);
        }
        else
        {
            addTransaction($req->accountID, $req->date, 0, $req->amount, $ref, $req->notes);
        }

        return back()->with('success', 'Created Successfully');

    }

    public function delete($ref)
    {
        transactions::where('refID', $ref)->delete();
        depositWithdraw::where('refID', $ref)->delete();
        return redirect('/depositwithdraw')->with('success', 'Deleted Successfully');
    }
}
