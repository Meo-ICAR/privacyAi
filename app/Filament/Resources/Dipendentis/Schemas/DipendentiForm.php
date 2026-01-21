<?php

namespace App\Filament\Resources\Dipendentis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class DipendentiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cognome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('codice_fiscale')
                    ->required()
                    ->maxLength(16)
                    ->helperText('Dato PII - Criptato a riposo ex Art. 32 GDPR'),
                TextInput::make('email_aziendale')
                    ->email()
                    ->maxLength(255)
                    ->helperText('Email per comunicazioni e notifiche scadenze corsi'),
                Select::make('mansione_id')
                    ->relationship('mansione', 'nome')
                    ->searchable()
                    ->preload()
                    ->helperText('Ruolo aziendale per definizione profilo di rischio'),
                DatePicker::make('data_assunzione'),
                DatePicker::make('data_dimissioni'),
                Select::make('filiale_id')
                    ->relationship('filiale', 'nome')
                    ->searchable()
                    ->preload()
                    ->helperText('Sede fisica di assegnazione del dipendente'),
                Toggle::make('is_active')
                    ->default(true)
                    ->helperText("Stato del dipendente nell'organico attivo"),
                SpatieMediaLibraryFileUpload::make('documento_identita')
                    ->collection('documento_identita')
                    ->helperText('Copia del documento di identità (Pest PII)'),
                SpatieMediaLibraryFileUpload::make('documenti')
                    ->collection('documenti')
                    ->multiple()
                    ->helperText('Contratti, Lettere di incarico, etc.'),
            ]);
    }
}
