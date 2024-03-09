<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function details()
    {
        return $this->hasMany(purchase_details::class, 'purchaseID');
    }

    public function vendor()
    {
        return $this->belongsTo(account::class, 'vendorID');
    }

    public function account()
    {
        return $this->belongsTo(account::class, 'accountID');
    }
}
