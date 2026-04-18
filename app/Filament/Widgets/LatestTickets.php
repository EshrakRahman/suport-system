<?php

namespace App\Filament\Widgets;

use App\Models\Role;
use App\Models\Ticket;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestTickets extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $user = auth()->user();
                $query = Ticket::query();

                // 1. Use 'where' on the collection to see if 'Admin' exists
                // We use strtolower to keep it safe from typos
                $isAdmin = $user->roles->contains('name', Role::ROLES['Admin']);

                if ($isAdmin) {
                    // Admin: Show everything
                    return $query;
                }

                // Agent: Show only assigned
                return $query->where('assigned_to', $user->id);
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Ticket $ticket): ?string => $ticket->description || null),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => Ticket::STATUS['Archived'],
                        'danger' => Ticket::STATUS['Open'],
                        'success' => Ticket::STATUS['Closed'],
                    ]),
                TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => Ticket::PRIORITY['Low'],
                        'warning' => Ticket::PRIORITY['Medium'],
                        'danger' => Ticket::PRIORITY['High'],
                    ]),
                TextColumn::make('assignedTo.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignedBy.name')
                    ->searchable()
                    ->sortable(),
                TextInputColumn::make('comment'),
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
