<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->autofocus(),
                TextInput::make('email')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->required()
                    ->password(),
            ]);
    }
}
