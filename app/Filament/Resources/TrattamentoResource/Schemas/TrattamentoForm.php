<?php

namespace App\Filament\Resources\TrattamentoResource\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class TrattamentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Generali')
                    ->description('Dettagli principali del trattamento dati personali')
                    ->schema([
                        TextInput::make('nome')
                            ->label('Nome Trattamento')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nome identificativo del trattamento (es. Gestione Risorse Umane)'),
                        
                        Textarea::make('descrizione')
                            ->label('Descrizione')
                            ->rows(3)
                            ->helperText('Descrizione dettagliata delle attività di trattamento'),
                    ])
                    ->columns(1),
                
                Section::make('Finalità e Base Giuridica')
                    ->description('Scopo del trattamento e fondamento legale')
                    ->schema([
                        Textarea::make('finalita')
                            ->label('Finalità del Trattamento')
                            ->required()
                            ->rows(3)
                            ->helperText('Scopi specifici del trattamento (es. Gestione contrattuale, adempimenti fiscali)'),
                        
                        Textarea::make('base_giuridica')
                            ->label('Base Giuridica')
                            ->required()
                            ->rows(2)
                            ->helperText('Fondamento legale del trattamento (es. Art. 6(1)(b) GDPR, Art. 6(1)(c) GDPR)'),
                    ])
                    ->columns(1),
                
                Section::make('Categorie Interessati')
                    ->description('Tipologie di dati personali trattati')
                    ->schema([
                        Select::make('categorieDati')
                            ->label('Categorie di Dati')
                            ->relationship('categorieDati', 'nome')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->helperText('Seleziona tutte le categorie di dati trattate'),
                    ])
                    ->columns(1),
                
                Section::make('Destinatari e Trasferimenti')
                    ->description('Chi può accedere ai dati e trasferimenti internazionali')
                    ->schema([
                        Textarea::make('destinatari')
                            ->label('Destinatari')
                            ->rows(3)
                            ->helperText('Categorie di soggetti che possono accedere ai dati (es. Dipendenti, Consulenti, Autorità)'),
                        
                        Textarea::make('trasferimenti_extra_ue')
                            ->label('Trasferimenti Extra UE')
                            ->rows(2)
                            ->helperText('Paesi extra UE verso cui i dati vengono trasferiti'),
                    ])
                    ->columns(1),
                
                Section::make('Conservazione e Sicurezza')
                    ->description('Periodi di conservazione e misure di sicurezza implementate')
                    ->schema([
                        Textarea::make('termini_conservazione')
                            ->label('Termini di Conservazione')
                            ->rows(2)
                            ->helperText('Criteri e periodi di conservazione dei dati'),
                        
                        Textarea::make('misure_sicurezza')
                            ->label('Misure di Sicurezza')
                            ->rows(3)
                            ->helperText('Misure tecniche e organizzative per la sicurezza dei dati'),
                    ])
                    ->columns(1),
                
                Section::make('Stato')
                    ->description('Stato attuale del trattamento')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true)
                            ->helperText('Indica se il trattamento è attualmente in uso'),
                    ])
                    ->columns(1),
            ]);
    }
}
