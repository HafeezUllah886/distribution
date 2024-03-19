<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(sale_details::class, 'salesID');
    }

    public function customer()
    {
        return $this->belongsTo(account::class, 'customerID');
    }

    public function payments()
    {
        return $this->hasMany(sale_payment::class, 'salesID');
    }
    public function salesmen()
    {
        return $this->belongsTo(salesman::class, 'salesmenID',);
    }
    public function orderbooker()
    {
        return $this->belongsTo(orderbooker::class, 'orderbookerID');
    }

    
}
