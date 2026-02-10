<?php

namespace App\Filament\Resources\DataBreachResource\Schemas;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;

class DataBreachInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $schema
            ->components([
                Section::make('Informazioni Generali')
                    ->description('Dettagli principali della violazione dati')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Descrizione Violazione')
                            ->size('text-lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        TextEntry::make('notes')
                            ->label('Note Aggiuntive')
                            ->placeholder('Nessuna nota aggiuntiva')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                Section::make('Tempi e Date')
                    ->description('Cronologia degli eventi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('occurred_at')
                                    ->label('Data e Ora Violazione')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->icon('heroicon-o-calendar'),
                                TextEntry::make('detected_at')
                                    ->label('Data e Ora Rilevamento')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->icon('heroicon-o-clock'),
                            ]),
                    ])
                    ->columns(2),
                Section::make('Classificazione')
                    ->description('Valutazione del rischio e stato attuale')
                    ->schema([
                        Split::make([
                            TextEntry::make('risk_level')
                                ->label('Livello di Rischio')
                                ->badge()
                                ->color(fn($state) => match ($state) {
                                    'low' => 'success',
                                    'medium' => 'warning',
                                    'high' => 'danger',
                                    'critical' => 'danger',
                                    default => 'gray',
                                })
                                ->formatStateUsing(fn($state) => match ($state) {
                                    'low' => 'Basso',
                                    'medium' => 'Medio',
                                    'high' => 'Alto',
                                    'critical' => 'Critico',
                                    default => $state,
                                }),
                            TextEntry::make('status')
                                ->label('Stato Attuale')
                                ->badge()
                                ->color(fn($state) => match ($state) {
                                    'open' => 'danger',
                                    'investigating' => 'warning',
                                    'closed' => 'success',
                                    default => 'gray',
                                })
                                ->formatStateUsing(fn($state) => match ($state) {
                                    'open' => 'Aperto',
                                    'investigating' => 'In Indagine',
                                    'closed' => 'Chiuso',
                                    default => $state,
                                }),
                        ]),
                    ])
                    ->columns(1),
                Section::make('Notifiche GDPR')
                    ->description('Tracciamento delle notifiche obbligatorie')
                    ->schema([
                        Group::make([
                            Split::make([
                                IconEntry::make('is_notified_authority')
                                    ->label('Autorità di Controllo')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                TextEntry::make('authority_notified_at')
                                    ->label('Data Notifica Autorità')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->placeholder('Non notificata')
                                    ->formatStateUsing(fn($state) => $state ? $state->format('d/m/Y H:i:s') : 'Non notificata'),
                            ]),
                            Split::make([
                                IconEntry::make('is_notified_subjects')
                                    ->label('Interessati')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                TextEntry::make('subjects_notified_at')
                                    ->label('Data Notifica Interessati')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->placeholder('Non notificati')
                                    ->formatStateUsing(fn($state) => $state ? $state->format('d/m/Y H:i:s') : 'Non notificati'),
                            ]),
                        ])->columns(2),
                    ])
                    ->collapsible()
                    ->collapsed(fn($record) => !$record->is_notified_authority && !$record->is_notified_subjects),
                Section::make('Informazioni Sistema')
                    ->description('Metadati della violazione')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('mandante.ragione_sociale')
                                    ->label('Mandante')
                                    ->placeholder('Nessun mandante associato')
                                    ->badge()
                                    ->color('primary'),
                                TextEntry::make('created_at')
                                    ->label('Creato il')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->icon('heroicon-o-calendar'),
                                TextEntry::make('updated_at')
                                    ->label('Aggiornato il')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->icon('heroicon-o-arrow-path'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
