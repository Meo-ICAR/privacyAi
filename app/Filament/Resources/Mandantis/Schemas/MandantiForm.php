<?php

namespace App\Filament\Resources\Mandantis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class MandantiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ragione_sociale')
                    ->required()
                    ->maxLength(255)
                    ->helperText("Nome legale dell'azienda cliente"),
                TextInput::make('p_iva')
                    ->label('P. IVA')
                    ->required()
                    ->maxLength(11)
                    ->unique(ignoreRecord: true)
                    ->helperText('Identificativo fiscale univoco'),
                TextInput::make('titolare_trattamento')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Titolare del Trattamento'),
                TextInput::make('email_referente')
                    ->email()
                    ->nullable()
                    ->maxLength(255)
                    ->helperText('Contatto primario per comunicazioni privacy'),
                TextInput::make('website')
                    ->url()
                    ->nullable()
                    ->maxLength(255)
                    ->helperText('Sito web aziendale'),
                Select::make('holding_id')
                    ->relationship('holding', 'ragione_sociale')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Riferimento alla Holding di appartenenza'),
                Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Stato di validità del contratto/tenant'),
            ]);
    }
}
