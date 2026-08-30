<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->imageSize(50),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('good_qty')
                    ->label('Good')
                    ->numeric(),
                TextColumn::make('damaged_qty')
                    ->label('Damaged')
                    ->numeric(),
                TextColumn::make('borrowed_qty')
                    ->label('Borrowed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lost_qty')
                    ->label('Lost')
                    ->numeric(),
                TextColumn::make('available_qty')
                    ->label('Available')
                    ->numeric(),
                TextColumn::make('total_qty')
                    ->numeric()
                    ->label('Total'),
                IconColumn::make('is_available')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),   
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationShip('category', 'name'),
                TernaryFilter::make('is_available')
                    ->label('Availability')
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
