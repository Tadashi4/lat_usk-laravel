<?php

namespace App\Filament\Resources\AssetReturns\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AssetReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ticket_id')
                    ->required()
                    ->label('Ticket Number')
                    ->relationship('ticket', 'ticket_number', fn($query) => $query->where('status', 'verifying'))
                    ->afterStateUpdated(fn($state, set )=>
                    ),
                Select::make('user_id')
                    ->required()
                    ->label('Verified By')
                    ->relationship('user', 'name')
                    ->default(Auth::id())
                    ->hidden(),
                Select::make('asset_id')
                    ->required()
                    ->label('Asset Name')
                    ->relationship('asset', 'name')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->readOnly(),
                Select::make('condition')
                    ->options(['good' => 'Good', 'damaged' => 'Damaged', 'lost' => 'Lost'])
                    ->default('good')
                    ->required(),
                DateTimePicker::make('returned_at')
                    ->required()
                    ->default(fn()=>Carbon::now())
                    ->hidden(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
