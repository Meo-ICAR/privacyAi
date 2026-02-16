<?php

namespace App\Filament\Resources\Holdings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HoldingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Holding')
                    ->schema([
                        TextInput::make('ragione_sociale')
                            ->label('Ragione Sociale')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('codice_gruppo', Str::slug($state))),
                        TextInput::make('p_iva')
                            ->label('Partita IVA')
                            ->required()
                            ->maxLength(20),
                        TextInput::make('codice_gruppo')
                            ->label('Codice Gruppo')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('holdings/logos')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
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
