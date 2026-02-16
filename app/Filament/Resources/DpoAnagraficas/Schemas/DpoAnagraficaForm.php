<?php

namespace App\Filament\Resources\DpoAnagraficas\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class DpoAnagraficaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('denominazione')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Es: "Studio Privacy Romeo" o Nome Cognome'),
                TextInput::make('codice_fiscale')
                    ->maxLength(16),
                TextInput::make('partita_iva')
                    ->maxLength(11),
                TextInput::make('email_ordinaria')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('email_pec')
                    ->email()
                    ->maxLength(255),
                TextInput::make('telefono')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('indirizzo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cap')
                    ->required()
                    ->maxLength(5),
                TextInput::make('citta')
                    ->required()
                    ->maxLength(255),
                TextInput::make('provincia')
                    ->required()
                    ->maxLength(2),
                TextInput::make('numero_iscrizione_albo')
                    ->maxLength(255)
                    ->helperText('Es: Avvocati, Ingegneri, etc.'),
                TextInput::make('certificazioni')
                    ->maxLength(255)
                    ->helperText('Es: "UNI 11697:2017", "EIPASS"'),
                Toggle::make('is_persona_giuridica')
                    ->required()
                    ->default(true),
            ]);
    }
}
