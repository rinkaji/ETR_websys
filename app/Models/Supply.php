<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'item',
        'unit',
        'quantity',
        'purchase_supplies',
        'received_supplies',
        'inventory_end',
        'issued',
        'unit_cost',
        'amount'
    ];
}
