<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Ticket;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->autofocus()
                    ->required(),
                Textarea::make('description')
                    ->rows(3),
                Group::make()
                    ->schema([
                        Select::make('status')
                            ->options(Ticket::STATUS)
                            ->required(),

                        Select::make('priority')
                            ->options(Ticket::PRIORITY)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Group::make()
                    ->schema([
                        Select::make('assigned_to')
                            ->relationship('assignedTo', 'name'),
                        // Select::make('assigned_by')
                        //     ->relationship('assignedBy', 'name')
                        // Toggle::make('is_resolved'),

                    ])->columns(2)
                    ->columnSpanFull(),
                Textarea::make('comment')
                    ->rows(3),

            ])->columns(1);
    }
}
