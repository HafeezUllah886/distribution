<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\transactions;
use App\Models\vendorExpenses;
use Illuminate\Http\Request;

class VendorExpensesController extends Controller
{
    public function index()
    {
        $accounts = account::where('status', 'Active')->where('category', 'Business')->get();
        $vendors = account::where('status', 'Active')->where('category', 'Vendor')->get();
        $expenses = vendorExpenses::all();

        return view('account.vendor_expense.index', compact('accounts', 'expenses', 'vendors'));
    }

    public function store(request $req)
    {
        $ref = getRef();
        $req->merge(['refID' => $ref]);

        vendorExpenses::create($req->all());

        addTransaction($req->accountID, $req->date, 0, $req->amount, $ref, $req->notes);
        addTransaction($req->vendorID, $req->date, $req->amount, 0, $ref, $req->notes);

        return back()->with('success', "Expense created successfully");
    }

    public function delete($ref)
    {
        transactions::where('refID', $ref)->delete();
        vendorExpenses::where('refID', $ref)->delete();

        return redirect('/vendor/expense')->with('success', 'Expense Deleted successfully');
    }
}
