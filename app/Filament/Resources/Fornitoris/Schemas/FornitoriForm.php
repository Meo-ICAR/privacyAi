<?php

namespace App\Filament\Resources\Fornitoris\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FornitoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ragione_sociale')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Denominazione fornitore'),
                TextInput::make('p_iva')
                    ->required()
                    ->maxLength(11),
                TextInput::make('website')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Sito web aziendale'),
                TextInput::make('responsabile_trattamento')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Responsabile del Trattamento ( amministratore azienda)'),
                DatePicker::make('data_nomina')
                    ->required()
                    ->helperText('Data in cui abbiamo nominato il fornitore come Responsabile'),
                TextInput::make('email_referente')
                    ->email()
                    ->maxLength(255)
                    ->helperText('Contatto primario per comunicazioni privacy'),
                Select::make('locazione_dati')
                    ->options([
                        'UE' => 'UE',
                        'USA' => 'USA',
                        'Extra-UE' => 'Extra-UE',
                    ])
                    ->required()
                    ->default('UE')
                    ->helperText('Critico per Transfer Impact Assessment (TIA)'),
                Select::make('holding_id')
                    ->relationship('holding', 'ragione_sociale')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Riferimento alla Holding di appartenenza'),
                Textarea::make('note_compliance')
                    ->columnSpanFull()
                    ->helperText('Eventuali clausole contrattuali specifiche'),
                Select::make('aziendatipo_id')
                    ->relationship('aziendaTipo', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Tipologia di azienda'),
                SpatieMediaLibraryFileUpload::make('contratto')
                    ->collection('contratto')
                    ->helperText('Contratto DPA firmato'),
                SpatieMediaLibraryFileUpload::make('documenti')
                    ->collection('documenti')
                    ->multiple()
                    ->helperText('Certificazioni ISO, Privacy Policy, etc.'),
            ]);
    }
}
