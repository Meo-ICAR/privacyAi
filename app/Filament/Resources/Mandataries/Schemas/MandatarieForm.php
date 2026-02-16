<?php

namespace App\Filament\Resources\Mandataries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MandatarieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ragione_sociale')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Titolare del Trattamento (Cliente del Call Center)'),
                TextInput::make('p_iva')
                    ->label('P. IVA')
                    ->required()
                    ->maxLength(11),
                TextInput::make('website')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Sito web aziendale'),
                TextInput::make('landingpage')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Landing page per mandataria'),
                DatePicker::make('data_ricezione_nomina')
                    ->required()
                    ->helperText('Data in cui la Mandataria ha nominato il Mandante come Responsabile'),
                TextInput::make('titolare_trattamento')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Titolare del Trattamento'),
                TextInput::make('email_referente')
                    ->email()
                    ->maxLength(255)
                    ->helperText('Contatto primario per comunicazioni privacy'),
                Select::make('aziendatipo_id')
                    ->relationship('aziendaTipo', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Tipologia di azienda'),
                Select::make('holding_id')
                    ->relationship('holding', 'ragione_sociale')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Riferimento alla Holding di appartenenza'),
                SpatieMediaLibraryFileUpload::make('documenti')
                    ->collection('documenti')
                    ->multiple()
                    ->helperText('Documenti mandante/mandataria'),

                Section::make('Compliance & DPA')
                    ->schema([
                        TextInput::make('compliance_score')
                            ->label('Punteggio Compliance')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('/ 100')
                            ->helperText('Valutazione del livello di compliance (0-100)'),
                        Select::make('dpa_status')
                            ->label('Stato DPA')
                            ->options([
                                'missing' => 'Mancante',
                                'draft' => 'Bozza',
                                'sent' => 'Inviato',
                                'signed' => 'Firmato',
                                'expired' => 'Scaduto',
                            ])
                            ->default('missing')
                            ->required(),
                        DatePicker::make('dpa_expires_at')
                            ->label('Scadenza DPA'),
                        SpatieMediaLibraryFileUpload::make('dpa_document')
                            ->collection('dpa_documents')
                            ->label('Documento DPA Firmato')
                            ->downloadable()
                            ->openable(),
                    ])->columns(2),
                Section::make('Trattamento Dati Personali')
                    ->schema([
                        Textarea::make('categorie_dati')
                            ->label('Categorie di Dati')
                            ->columnSpanFull(),
                        Textarea::make('descrizione_categorie_dati')
                            ->label('Descrizione Categorie Dati')
                            ->columnSpanFull(),
                        Textarea::make('categorie_interessati')
                            ->label('Categorie di Interessati')
                            ->columnSpanFull(),
                        Textarea::make('finalita_trattamento')
                            ->label('Finalità del Trattamento')
                            ->columnSpanFull(),
                        Select::make('tipo_trattamento')
                            ->options([
                                'manuale' => 'Manuale',
                                'digitale' => 'Digitale',
                                'misto' => 'Misto',
                            ])
                            ->default('digitale'),
                        Textarea::make('termini_conservazione')
                            ->label('Termini di Conservazione'),
                        Textarea::make('paesi_trasferimento_dati')
                            ->label('Trasferimenti Dati'),
                        Textarea::make('misure_sicurezza_tecniche')
                            ->label('Misure di Sicurezza Tecniche')
                            ->columnSpanFull(),
                        Textarea::make('misure_sicurezza_organizzative')
                            ->label('Misure di Sicurezza Organizzative')
                            ->columnSpanFull(),
                        Textarea::make('responsabili_esterni')
                            ->label('Responsabili Esterni'),
                        Textarea::make('base_giuridica')
                            ->label('Base Giuridica'),
                        Toggle::make('richiesto_consenso')
                            ->label('Richiesto Consenso'),
                        Textarea::make('modalita_raccolta_consenso')
                            ->label('Modalità Raccolta Consenso')
                            ->visible(fn(callable $get) => $get('richiesto_consenso')),
                        TextInput::make('contitolare_trattamento')
                            ->label('Contitolare del Trattamento'),
                        Textarea::make('note_gdpr')
                            ->label('Note GDPR')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
