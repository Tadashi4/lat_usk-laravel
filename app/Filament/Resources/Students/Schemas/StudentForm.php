<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('classroom_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('profie_picture'),
            ]);
    }
}
