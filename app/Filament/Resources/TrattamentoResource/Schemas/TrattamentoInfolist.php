<?php

namespace App\Filament\Resources\TrattamentoResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;

class TrattamentoInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informazioni Generali')
                    ->description('Dettagli principali del trattamento dati personali')
                    ->schema([
                        TextEntry::make('nome')
                            ->label('Nome Trattamento')
                            ->size('text-lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        
                        TextEntry::make('descrizione')
                            ->label('Descrizione')
                            ->placeholder('Nessuna descrizione disponibile')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                
                Section::make('Finalità e Base Giuridica')
                    ->description('Scopo del trattamento e fondamento legale')
                    ->schema([
                        Split::make([
                            TextEntry::make('finalita')
                                ->label('Finalità del Trattamento')
                                ->placeholder('Nessuna finalità specificata'),
                            
                            TextEntry::make('base_giuridica')
                                ->label('Base Giuridica')
                                ->placeholder('Nessuna base giuridica specificata'),
                        ]),
                    ])
                    ->columns(1),
                
                Section::make('Categorie di Dati')
                    ->description('Tipologie di dati personali trattati')
                    ->schema([
                        TextEntry::make('categorie_interessati')
                            ->label('Categorie Interessati')
                            ->placeholder('Nessuna categoria specificata')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                
                Section::make('Destinatari e Trasferimenti')
                    ->description('Chi può accedere ai dati e trasferimenti')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('destinatari')
                                    ->label('Destinatari')
                                    ->placeholder('Nessun destinatario specificato'),
                                
                                TextEntry::make('trasferimenti_extra_ue')
                                    ->label('Trasferimenti Extra UE')
                                    ->placeholder('Nessun trasferimento extra UE'),
                            ]),
                    ])
                    ->columns(2),
                
                Section::make('Conservazione e Sicurezza')
                    ->description('Periodi di conservazione e misure di sicurezza')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('termini_conservazione')
                                    ->label('Termini di Conservazione')
                                    ->placeholder('Nessun termine specificato'),
                                
                                TextEntry::make('misure_sicurezza')
                                    ->label('Misure di Sicurezza')
                                    ->placeholder('Nessuna misura specificata'),
                            ]),
                    ])
                    ->columns(2),
                
                Section::make('Stato e Metadati')
                    ->description('Stato attuale e informazioni di sistema')
                    ->schema([
                        Split::make([
                            IconEntry::make('is_active')
                                ->label('Stato')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle')
                                ->trueColor('success')
                                ->falseColor('danger'),
                            
                            TextEntry::make('mandante.ragione_sociale')
                                ->label('Mandante')
                                ->placeholder('Nessun mandante associato')
                                ->badge()
                                ->color('primary'),
                        ]),
                        
                        Grid::make(2)
                            ->schema([
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
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
