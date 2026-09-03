<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetFine extends Model
{

use LogsActivity;

public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
    ->logAll()
    ->logOnlyDirty();
}
    protected $fillable = [
        'asset_return_id',
        'type',
        'amount',
        'notes',
    ];

    public function assetReturn()
    {
        return $this->belongsTo(AssetReturn::class);
    }
}
