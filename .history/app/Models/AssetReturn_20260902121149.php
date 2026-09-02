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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    protected static function booted()
    {
        static::creating(function ($assetReturn )
        {
            $ticket = Ticket::find($assetReturn->ticket_id);
            if ($ticket) {
                $ticket->status = 'returned';
                $ticket->returned_at = now();
                $ticket->save();
            }
        });
    }
}
