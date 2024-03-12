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

    public function account()
    {
        return $this->belongsTo(account::class, 'accountID');
    }
}
