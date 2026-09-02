<?php

namespace App\Filament\Resources\AssetReturns\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetFinesRelationManager extends RelationManager
{
    protected static string $relationship = 'assetFines';
    protected static ?string $title = 'Asset Fines';
    protected static ?string $recordTitleAttribute = 'type';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Fine Type')
                    ->required()
                    ->options([
                        'late' => 'Late Return',
                        'damage' => 'Damage',
                        'lost' => 'Lost',
                    ]),

                    TextInput::make('amount')
                    ->label('Fine Amount')
                    ->numeric()
                    ->prefix('IDR')
                    ->required(),

                    Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->label('Fine Type')
                    ->badge()
                    ->color([
                        'late' => 'warning',
                        'damage' => 'danger',
                        'lost' => 'gray',
                    ])
                    ->searchable(),

                    TextColumn::make('amount')
                    ->label('Fine Amount')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
