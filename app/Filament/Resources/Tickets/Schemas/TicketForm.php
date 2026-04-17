<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
                            ->required()
                            ->in(Ticket::STATUS),

                        Select::make('priority')
                            ->options(Ticket::PRIORITY)
                            ->required()
                            ->in(Ticket::PRIORITY),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Group::make()
                    ->schema([
                        Select::make('assigned_to')
                            ->options(
                                User::whereHas('roles', function (Builder $builder) {
                                    $builder->where('name', Role::ROLES['Agent']);
                                })->pluck('name', 'id')->toArray()
                            )
                            ->required(),

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
