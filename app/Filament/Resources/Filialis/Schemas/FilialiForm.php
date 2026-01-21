<?php

namespace App\Filament\Resources\Filialis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FilialiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Esempio: Sede Roma, Filiale Napoli Nord'),
                TextInput::make('indirizzo')
                    ->maxLength(255),
                TextInput::make('citta')
                    ->maxLength(255),
                TextInput::make('codice_sede')
                    ->maxLength(255)
                    ->helperText('Codice interno identificativo'),
            ]);
    }
}
