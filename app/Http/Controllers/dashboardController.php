<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {
        $startDate = Carbon::now()->subDays(10);
        $endDate = Carbon::now();

        $data = [];
        for ($date = $startDate; $date->lte($endDate); $date = $date->addDay()) {
            $sales = DB::table('sale_details')
                ->whereDate('date', $date->format('Y-m-d'))
                ->sum('amount');

            $returns = DB::table('sale_return_details')
                ->whereDate('date', $date->format('Y-m-d'))
                ->sum('amount');

            $expenses = DB::table('expenses')
                ->whereDate('date', $date->format('Y-m-d'))
                ->sum('amount');

            $data[] = [
                'date' => $date->format('d-m'),
                'sales' => number_format($sales - $returns,0),
                'expenses' => number_format($expenses,0),
            ];
        }

        $dates = array_column($data, 'date');
        $sales = array_column($data, 'sales');
        $expenses = array_column($data, 'expenses');
        return view('dashboard.index', compact('dates', 'sales', 'expenses'));
    }
}
