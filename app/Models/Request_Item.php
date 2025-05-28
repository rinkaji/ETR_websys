<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request_Item extends Model
{
    protected $table = 'request_items';

    protected $fillable = [
        'request_id',
        'supply_id',
        'quantity',
    ];

    public function supply()
    {
        return $this->belongsTo(\App\Models\Supply::class, 'supply_id');
    }

    public function request()
    {
        return $this->belongsTo(\App\Models\request::class, 'request_id');
    }
}
