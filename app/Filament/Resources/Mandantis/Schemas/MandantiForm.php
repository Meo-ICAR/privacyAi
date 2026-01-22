<?php

namespace App\Filament\Resources\Mandantis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

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
                Select::make('aziendatipo_id')
                    ->relationship('aziendaTipo', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Tipologia di azienda'),
                TextInput::make('stripe_prezzo_mensile')
                    ->label('Prezzo Mensile (€)')
                    ->numeric()
                    ->step(10)
                    //  ->required()
                    ->default(0)
                    ->prefix('€'),
                // Aggiungi questi nuovi campi
                Select::make('periodicita')
                    ->options([
                        1 => 'Mensile',
                        2 => 'Bimestrale',
                        3 => 'Trimestrale',
                        6 => 'Semestrale',
                    ])
                    ->required()
                    ->default(2)
                    ->label('Periodicità fatturazione'),
                TextInput::make('stripe_customer_id')
                    ->label('ID Cliente Stripe')
                    ->disabled()
                    ->maxLength(255),
                TextInput::make('stripe_subscription_id')
                    ->label('ID Abbonamento Stripe')
                    ->disabled()
                    ->maxLength(255),
                DatePicker::make('stripe_subscription_ends_at')
                    ->label('Scadenza abbonamento')
                    ->displayFormat('d/m/Y'),
                Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Stato di validità del contratto/tenant'),
                SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('logo')
                    ->image()
                    ->helperText('Logo aziendale'),
                SpatieMediaLibraryFileUpload::make('documenti')
                    ->collection('documenti')
                    ->multiple()
                    ->helperText('Documenti generali (Visura, DPA, etc.)'),
            ]);
    }
}
