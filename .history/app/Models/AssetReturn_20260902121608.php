<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        static::creating(function (AssetReturn $return)
        {
            if (Auth::check()) {
                $return->user_id ??= Auth::id();
            }

            $return->returned_at ??= now();
        });

        static::creating(function (AssetReturn $return)
        {
            if($return )
        });
    }
}
