<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\transactions;
use App\Models\transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        $trans = transfer::orderBy('id', 'desc')->get();
        $accounts = account::where('status', 'Active')->get();
        return view('account.transfer.index', compact('trans', 'accounts'));
    }

    public function store(Request $req)
    {
        if($req->from == $req->to)
        {
            return back()->with('error', "Please Select Different Accounts");
        }
        $ref = getRef();
        $req->merge(['refID' => $ref]);

        transfer::create($req->all());

        $from = account::find($req->from);
        $to = account::find($req->to);
        addTransaction($req->from, $req->date,0, $req->amount, $ref, "Transfered Out to $to->name");
        addTransaction($req->to, $req->date,$req->amount, 0, $ref, "Transfered In from $from->name");

        return back()->with('success', "Transfered Successfully");

    }

    public function delete($ref)
    {
        transactions::where('refID', $ref)->delete();
        transfer::where('refID', $ref)->delete();

        return redirect('/transfer')->with('success', "Transfer Deleted Successfully");
    }
}
