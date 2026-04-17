<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('updatePassword')
                ->schema([
                    TextInput::make('password')->required()->password()->confirmed(),
                    TextInput::make('password_confirmation')->required()->password(),

                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'password' => $data['password'],
                    ]);

                    Notification::make()
                        ->title('Password saved successfully')
                        ->success()
                        ->send();
                })

        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
