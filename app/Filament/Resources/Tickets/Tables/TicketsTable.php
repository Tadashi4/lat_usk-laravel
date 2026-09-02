<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket#')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Requester')
                    ->sortable(),
                TextColumn::make('asset.name')
                    ->label('Asset Name')
                    ->sortable(),
                TextColumn::make('qty')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('booked_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('borrowed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('due_at')
                    ->date()
                    ->sortable()
                    ->icon('heroicon-m-flag')
                    ->iconColor(function($record){
                        if(in_array($record->status,['booked', 'cancelled']) || !$record->due_at) return null;

                        $isOverdue = $record->due_at->startOfDay()->isPast();
                        $isLateReturn = $record->status === 'returned' && $record->returned_at?->startOfDay()->gt($record->due_at->startOfDay());

                        return match(true){
                            $record->status === 'returned' => $isLateReturn ? 'warning' : 'success',
                            in_array($record->status, ['borrowed', 'verifying']) => $isOverdue ? 'danger' : 'success',
                            default => null
                        };
                    })
                    ->description(function($record){
                        if(in_array($record->status,['booked', 'cancelled']) || !$record->due_at) return null;

                        $due = $record->due_at->startOfDay();
                        $now = now()->startOfDay();
                        $return = $record->returned_at?->startOfDay();

                        if ($record->status === 'returned' && $return) {
                            $diff = $due->diffInDays($return, false);
                            return $diff > 0 ? "Return late by {$diff} days." : "Returned on time.";
                        }

                        $diff = $now->diffInDays($due, false);
                        return match(true){
                            $diff < 0 => "Overdue by " .abs($diff) . "days.",
                            $diff == 0 => 'Due today!',
                            default => '{$diff} days remaining'
                        };
                    }),
                TextColumn::make('returned_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string=>match($state){
                        'booked' => 'Reserved',
                        'borrowed' => 'On Loan',
                        'verifying' => 'Review',
                        'returned' => 'Returned',
                        'cancelled' => 'Cancelled',
                        default => ucfirst($state)
                    })
                    ->color(fn(string $state): string=>match($state){
                        'booked' => 'info',
                        'borrowed' => 'success',
                        'verifying' => 'warning',
                        'returned' => 'success',
                        'cancelled' => 'danger',
                    }),
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
                //
            ])
            ->recordActions([
                Action::make('approveBorrowing')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'booked')
                    ->action(fn($record) =>$record->update([
                        'status' => 'borrowed',
                        'borrowed_at' => now(),
                    ]))->button(),
                Action::make('cancelBorrowing')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'booked')
                    ->action(fn($record) =>$record->update([
                        'status' => 'cancelled',
                    ]))->button(),
                Action::make('verifyReturn')
                    ->label('Verify Return')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'borrowed')
                    ->action(fn($record) =>$record->update([
                        'status' => 'verifying',
                    ]))->button(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                 Action::make('completed')
                    ->label('Completed')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'verifying')
                    ->action(fn($record) =>$record->update([
                        'status' => 'returned',
                        'returned_at' => now(),
                    ]))->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
