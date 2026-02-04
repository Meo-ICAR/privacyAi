<?php

namespace App\Filament\Resources\GmailLabels\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Infolist;

class GmailLabelInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informazioni Generali')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('google_id')
                                    ->label('Google ID')
                                    ->copyable()
                                    ->helperText('ID univoco della label da Google'),
                                TextEntry::make('name')
                                    ->label('Nome Label')
                                    ->size('text-lg')
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('dominio')
                                    ->label('Dominio')
                                    ->formatStateUsing(fn ($state) => $state ?: '—')
                                    ->copyable()
                                    ->placeholder('Nessun dominio'),
                                TextEntry::make('type')
                                    ->label('Tipo')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'user' => 'success',
                                        'system' => 'warning',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn ($state) => match ($state) {
                                        'user' => 'User',
                                        'system' => 'System',
                                        default => $state,
                                    }),
                            ]),
                    ]),
                Section::make('Associazione Mandante')
                    ->schema([
                        Split::make([
                            TextEntry::make('mandante.ragione_sociale')
                                ->label('Mandante')
                                ->size('text-lg')
                                ->weight('bold')
                                ->formatStateUsing(fn ($record) => $record->mandante 
                                    ? $record->mandante->ragione_sociale 
                                    : 'Nessun mandante assegnato')
                                ->placeholder('Nessun mandante assegnato'),
                            IconEntry::make('has_mandante')
                                ->label('Stato Associazione')
                                ->boolean()
                                ->getStateUsing(fn ($record) => $record->mandante_id !== null)
                                ->trueIcon('heroicon-o-check-circle')
                                ->falseIcon('heroicon-o-x-circle')
                                ->trueColor('success')
                                ->falseColor('danger'),
                        ]),
                        Group::make([
                            TextEntry::make('mandante.website')
                                ->label('Website Mandante')
                                ->formatStateUsing(fn ($record) => $record->mandante 
                                    ? $record->mandante->website 
                                    : '—')
                                ->url(fn ($record) => $record->mandante?->website)
                                ->openUrlInNewTab()
                                ->placeholder('Nessun website'),
                            TextEntry::make('mandante.p_iva')
                                ->label('P. IVA Mandante')
                                ->formatStateUsing(fn ($record) => $record->mandante 
                                    ? $record->mandante->p_iva 
                                    : '—')
                                ->placeholder('Nessuna P. IVA'),
                        ])->columns(2),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => !$record->mandante_id),
                Section::make('Timestamps')
                    ->schema([
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
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
