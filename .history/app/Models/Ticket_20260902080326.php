<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [

    'user_id',
    'asset_id',
    'ticket_number',
    'qty',
    'booked_at',
    'borrowed_at',
    'due_at',
    'returned_at',
    'status',
    'note'
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $latest = static::max('id') + 1;
            $ticket->ticket_number = 'TCK-' . str_pad($latest, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user(){

    return $this->belongsTo(User::class);
    }
    public function asset(){

    return $this->belongsTo(Asset::class);
    }

    public function AssetReturns()
    {
        return $this->hasMany(AssetReturn::class);
    }
}
