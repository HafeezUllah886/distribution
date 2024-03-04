<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\expense;
use App\Models\transactions;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $accounts = account::where('status', 'Active')->get();
        $expenses = expense::all();

        return view('account.expense.index', compact('accounts', 'expenses'));
    }

    public function store(request $req)
    {
        $ref = getRef();
        $req->merge(['refID' => $ref]);

        expense::create($req->all());

        addTransaction($req->accountID, $req->date, 0, $req->amount, $ref, $req->notes);

        return back()->with('success', "Expense created successfully");
    }

    public function delete($ref)
    {
        transactions::where('refID', $ref)->delete();
        expense::where('refID', $ref)->delete();

        return redirect('/expense')->with('success', 'Expense Deleted successfully');
    }
}
