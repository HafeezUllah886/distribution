<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale_payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(account::class, 'accountID');
    }    
}
