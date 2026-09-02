<?php

namespace App\Filament\Resources\AssetReturns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ticket_id')
                    ->required()
                    ->label('Ticket Number')
                    ->relationship('ticket', 'ticket_number'),
                Select::make('user_id')
                    ->required()
                    ->label('Verified By')
                    ->relationship('user', 'name')
                    ->default(Auth::id()),
                TextInput::make('asset_id')
                    ->required()
                    ->numeric(),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('condition')
                    ->options(['good' => 'Good', 'damaged' => 'Damaged', 'lost' => 'Lost'])
                    ->default('good')
                    ->required(),
                DateTimePicker::make('returned_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
