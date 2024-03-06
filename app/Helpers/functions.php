<?php

use App\Models\products;
use App\Models\reference;
use App\Models\transactions;
use Carbon\Carbon;

function getRef()
{
    $ref = reference::first();
    if ($ref) {
        $ref->ref = $ref->ref + 1;
    } else {
        $ref = new reference();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}


function addTransaction($accountID, $date, $credit, $debt, $refID, $desc)
{
    transactions::create([
        'accountID' => $accountID,
        'date' => $date,
        'cr' => $credit,
        'db' => $debt,
        'refID' => $refID,
        'notes' => $desc,
    ]);
}

function getAccountBalance($id)
{
    $cr = transactions::where('accountID', $id)->sum('cr');
    $db = transactions::where('accountID', $id)->sum('db');

    return $cr - $db;
}

function getInitials($string)
{
    $words = explode(' ', $string);
    $initials = '';

    if (count($words) === 1) {
        $initials = substr($words[0], 0, 3);
    } else {
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        // Limit the initials to 3 characters
        $initials = substr($initials, 0, 3);
    }

    return $initials;
}

function firstDayOfMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();

    return $startOfMonth->format('Y-m-d');
}
function lastDayOfMonth()
{

    $endOfMonth = Carbon::now()->endOfMonth();

    return $endOfMonth->format('Y-m-d');
}

