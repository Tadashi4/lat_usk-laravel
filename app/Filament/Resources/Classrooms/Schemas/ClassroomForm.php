<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Major;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('major_id')
                    ->required()
                    ->label('Major')
                    ->relationship('major', 'name')
                    ->options(Major::where('is_active', true)->pluck('name', 'id')),
                TextInput::make('name')
                    ->required(),
                Select::make('level')
                    ->required()
                    ->label('Grade')
                    ->options([
                        10 => 'Grade X',
                        11 => 'Grade XI',
                        12 => 'Grade XII',
                        13 => 'Grade XIII', 
                    ]),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
