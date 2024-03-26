<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale_return extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(account::class, 'customerID', 'id');
    }
    public function account()
    {
        return $this->belongsTo(account::class, 'accountID', 'id');
    }
    public function orderBooker()
    {
        return $this->belongsTo(orderbooker::class, 'orderbookerID', 'id');
    }

    public function details()
    {
        return $this->hasMany(sale_return_details::class, 'salereturnID');
    }
}
