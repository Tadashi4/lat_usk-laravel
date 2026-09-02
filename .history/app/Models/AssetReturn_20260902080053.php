<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetReturn extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'asset_id',
        'qty',
        'condition',
        'returned_at',
        'notes',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
