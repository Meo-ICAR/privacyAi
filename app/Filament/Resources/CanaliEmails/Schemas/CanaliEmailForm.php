<?php

namespace App\Filament\Resources\CanaliEmails\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class CanaliEmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('email_provider_id')
                    ->relationship('emailProvider', 'nome') // Assuming 'nome' exists in email_providers
                    ->required()
                    ->searchable(),
                TextInput::make('label')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Es: Email DPO'),
                TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                    ->helperText("L'indirizzo email completo"),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->helperText('Criptata tramite Laravel Encrypter'),
            ]);
    }
}
