<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Models\Ticket;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\RichEditor\TipTapExtensions\TextColorExtension;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
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
                SelectFilter::make('status')
                    ->options(Ticket::STATUS)
                    ->placeholder('Filter by status'),
                SelectFilter::make('priority')
                    ->options(Ticket::PRIORITY)
                    ->placeholder('Filter by priority')
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
