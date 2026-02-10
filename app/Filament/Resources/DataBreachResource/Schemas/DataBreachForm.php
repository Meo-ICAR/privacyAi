<?php

namespace App\Filament\Resources\DataBreachResource\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class DataBreachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Generali')
                    ->description('Dettagli principali della violazione dati')
                    ->schema([
                        TextInput::make('description')
                            ->label('Descrizione Violazione')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Descrizione chiara e concisa della violazione'),
                        
                        Textarea::make('notes')
                            ->label('Note Aggiuntive')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Dettagli aggiuntivi, azioni correttive, ecc.'),
                    ])
                    ->columns(1),
                
                Section::make('Tempi e Date')
                    ->description('Quando è avvenuta e quando è stata scoperta la violazione')
                    ->schema([
                        DateTimePicker::make('occurred_at')
                            ->label('Data e Ora Violazione')
                            ->required()
                            ->native(false)
                            ->helperText('Quando è avvenuta effettivamente la violazione'),
                        
                        DateTimePicker::make('detected_at')
                            ->label('Data e Ora Rilevamento')
                            ->required()
                            ->native(false)
                            ->helperText('Quando è stata scoperta la violazione'),
                    ])
                    ->columns(2),
                
                Section::make('Classificazione')
                    ->description('Livello di rischio e stato attuale')
                    ->schema([
                        Select::make('risk_level')
                            ->label('Livello di Rischio')
                            ->options([
                                'low' => 'Basso',
                                'medium' => 'Medio', 
                                'high' => 'Alto',
                                'critical' => 'Critico',
                            ])
                            ->required()
                            ->default('low')
                            ->helperText('Valutare l\'impatto potenziale sugli interessati')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (in_array($state, ['high', 'critical'])) {
                                    $set('is_notified_authority', true);
                                }
                            }),
                        
                        Select::make('status')
                            ->label('Stato')
                            ->options([
                                'open' => 'Aperto',
                                'investigating' => 'In Indagine',
                                'closed' => 'Chiuso',
                            ])
                            ->required()
                            ->default('open')
                            ->helperText('Stato attuale della gestione della violazione'),
                    ])
                    ->columns(2),
                
                Section::make('Notifiche')
                    ->description('Tracciamento delle notifiche obbligatorie')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_notified_authority')
                                    ->label('Autorità Notificata')
                                    ->helperText('Se è stata notificata l\'autorità di controllo')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ($state && !$get('authority_notified_at')) {
                                            $set('authority_notified_at', now());
                                        } elseif (!$state) {
                                            $set('authority_notified_at', null);
                                        }
                                    }),
                                
                                DateTimePicker::make('authority_notified_at')
                                    ->label('Data Notifica Autorità')
                                    ->native(false)
                                    ->disabled()
                                    ->helperText('Data di notifica all\'autorità GDPR'),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_notified_subjects')
                                    ->label('Interessati Notificati')
                                    ->helperText('Se sono stati notificati gli interessati')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ($state && !$get('subjects_notified_at')) {
                                            $set('subjects_notified_at', now());
                                        } elseif (!$state) {
                                            $set('subjects_notified_at', null);
                                        }
                                    }),
                                
                                DateTimePicker::make('subjects_notified_at')
                                    ->label('Data Notifica Interessati')
                                    ->native(false)
                                    ->disabled()
                                    ->helperText('Data di notifica agli interessati'),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
