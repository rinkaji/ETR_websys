<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class request extends Model
{
    protected $fillable = [
        'request_id',
        'status',
        'office',
        'request_by',
        'request_by_designation',
        'received_by',
        'received_date',
        'received_by_designation',
        'released_by',
        'released_date',
        'released_by_designation',
        'user_id',
        'decline_reason',
    ];

    public function items()
    {
        return $this->hasMany(Request_Item::class, 'request_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
