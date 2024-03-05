<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\transactions;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index($filter = "All")
    {
        if($filter == "All")
        {   
            $accounts = account::all();
        }
        else
        {
            $accounts = account::where('category', $filter)->get();
        }
        
        return view('account.index', compact('accounts', 'filter'));
    }

    public function store(Request $req)
    {
        $check = account::where('name', $req->name)->count();

        if($check > 0)
        {
            return back()->with('error', 'Account Already Exists');
        }
        else
        {
            $account = account::create($req->except(['initial']));
            if($req->initial > 0)
            {
                addTransaction($account->id, now(), $req->initial, 0, getRef(), "Initial Amount");
            }

        }
        return back()->with('success', "Account Created");
    }

    public function update(request $req)
    {
        account::find($req->id)->update($req->except(['id']));

        return back()->with('success', "Account Updated");
    }

    public function statement($id, $start, $end)
    {
        $account = account::find($id);
        $trans = transactions::where('accountID', $id)
        ->whereBetween('date', [$start, $end])
        ->get();

        $pre_cr = transactions::where('accountID', $id)->whereDate('date', '<', $start)->sum('cr');
        $pre_db = transactions::where('accountID', $id)->whereDate('date', '<', $start)->sum('db');
        $opening_balance = $pre_cr - $pre_db;

        $cur_cr = transactions::where('accountID', $id)->whereDate('date', '<=', $end)->sum('cr');
        $cur_db = transactions::where('accountID', $id)->whereDate('date', '<=', $end)->sum('db');
        $closing_balance = $cur_cr - $cur_db;

        $balance = $opening_balance;
        foreach($trans as $tran)
        {
            $balance += $tran->cr;
            $balance -= $tran->db;
            $tran->balance = $balance;
        }

        return view('account.statement', compact('trans', 'start', 'end', 'opening_balance', 'closing_balance', 'account'));
    }

}
