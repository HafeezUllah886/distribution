<?php

namespace App\Http\Controllers;

use App\Models\salesman;
use Illuminate\Http\Request;

class loadSheetController extends Controller
{
    public function index()
    {
        $salesmans = salesman::all();

        return view('loadsheet.index', compact('salesmans'));
    }
}
