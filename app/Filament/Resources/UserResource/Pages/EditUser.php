<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Card::make()
            ->schema([
                TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

                TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

                DateTimePicker::make('email_verified_at')
                ->label('Email Verified At')
                ->nullable(),
                TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8),
            ])
            ->columns(2),
        ];
    }
}
