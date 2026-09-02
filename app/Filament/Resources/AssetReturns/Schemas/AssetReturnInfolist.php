<?php

namespace App\Filament\Resources\AssetReturns\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class AssetReturnInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Details')
                ->description('Reference Information for this asset return')
                ->schema([
                    Grid::make(3)
                    ->schema([
                        TextEntry::make('ticket.ticket_number')
                            ->label('Ticket Number'),
                        TextEntry::make('user.name')
                            ->label('Verified By'),
                        TextEntry::make('returned_at')
                            ->label('Returned Date')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                ]),
                Section::make('Asset Details')
                ->description('Details of the returned item and its state.')
                ->schema([
                    Grid::make(3)
                    ->schema([
                    TextEntry::make('asset.name')
                        ->label('Asset Name'),
                    TextEntry::make('qty')
                        ->label('Qty')
                        ->numeric(),
                    TextEntry::make('condition')
                        ->label('Condition')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'good' => 'success',
                            'damaged' => 'warning',
                            'lost' => 'danger',
                        })
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'good' => 'Good Condition',
                            'damaged' => 'Broken',
                            'lost' => 'Missing',
                        }),
                        TextEntry::make('notes')
                            ->label('Notes')
                    ]),
                ]),
            ]);
    }
}
