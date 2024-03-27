<?php

namespace App\Http\Controllers;

use App\Models\sale_return;
use App\Models\sales;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class customerSummaryController extends Controller
{
    public function index()
    {
        $customers = DB::table('accounts')
    ->where('accounts.category', '=', 'Customer')
    ->select('accounts.id', 'accounts.name', 'accounts.channel')
    ->get();

$data = [];
foreach ($customers as $customer) {
    $sales = sales::where('customerID', $customer->id)->get();
    $totalSales = 0;
    foreach($sales as $sale) {
        $totalSales += $sale->details->sum('amount');
    }

    $returns = sale_return::where('customerID', $customer->id)->get();
    $totalReturns = 0;
    foreach($returns as $return) {
        $totalReturns += $return->details->sum('amount');
    }

    $total = $totalSales - $totalReturns;

    $data[] = [$customer->name, $total]; // Combine name and total purchase
    $customer->purchases = $totalSales;
    $customer->returns = $totalReturns;
    $trans = transactions::where('accountID', $customer->id)->get();
    $customer->balance = $trans->sum('cr') - $trans->sum('db');
}

// Sort combined data by total purchase (descending order)
usort($data, function($a, $b) {
    return $b[1] - $a[1]; // Sort based on second element (total purchase)
});

// Limit to top 10 customers (optional)
$data = array_slice($data, 0, 10);

$customerNames = array_column($data, 0); // Extract names from sorted data
$totalPurchased = array_column($data, 1); // Extract total purchases from sorted data

return view('reports.customerSummary.index', compact('customerNames', 'totalPurchased', 'customers'));
    }

}
