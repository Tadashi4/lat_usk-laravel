<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->required()
                    ->label('Student Name')
                    ->relationship('user', 'name'),
                Select::make('classroom_id')
                    ->required()
                    ->label('Class')
                    ->relationship('classroom', 'name'),
                TextInput::make('nisn')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->validationMessages(['unique' => 'The NISN has already been registered'])
                    ->label('NISN'),
                TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->label('Phone Number'),
                Select::make('gender')
                    ->label('Gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                Textarea::make('address')
                    ->label('Address')
                    ->columnSpanFull(),
                FileUpload::make('profile_picture')
                    ->label('Profile Picture')
                    ->directory('Students')
                    ->disk('public'),
            ]);
    }
}
