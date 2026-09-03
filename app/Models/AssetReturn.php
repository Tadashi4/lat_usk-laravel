<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetReturn extends Model
{

use LogsActivity;

public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
    ->logAll()
    ->logOnlyDirty();
}
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
            if($return->ticket){
                $return->ticket->update([
                    'status' => 'returned',
                    'returned_at' => $return->returned_at,
                ]);
            }
        });
    }

    public function assetfines()
    {
        return $this->hasMany(AssetFine::class);
    }

    protected $casts = [
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];
}
