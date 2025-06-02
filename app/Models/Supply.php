<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'item',
        'description',
        'unit',
        'quantity',
        'unit_cost',
        'supply_from',
        'supply_from_quantity',
        'reorder_threshold',
    ];

    public function requestItems()
    {
        return $this->hasMany(\App\Models\Request_Item::class, 'supply_id');
    }
}
