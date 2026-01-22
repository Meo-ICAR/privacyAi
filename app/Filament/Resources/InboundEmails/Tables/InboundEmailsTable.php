<?php

namespace App\Filament\Resources\InboundEmails\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InboundEmailsTable
{
    // LISTA EMAIL (Tabella)

    public static function configure(Table $table): Table
    {
        return $table
            ->poll('30s')  // Auto-refresh ogni 30 secondi per vedere nuove mail
            ->defaultSort('received_at', 'desc')
            ->columns([
                // Colonna Mandante (utile se sei SuperAdmin)
                TextColumn::make('canale.mandante.ragione_sociale')
                    ->label('Mandante')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                // Stato Letto/Non Letto (Icona visiva)
                IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-s-envelope')  // Icona piena se non letta
                    ->trueColor('gray')
                    ->falseColor('primary')
                    ->tooltip(fn($state) => $state ? 'Già letta' : 'Da leggere'),
                // Mittente
                TextColumn::make('from_email')
                    ->label('Mittente')
                    ->description(fn(InboundEmail $record) => $record->from_name)
                    ->searchable(['from_email', 'from_name'])
                    ->sortable(),
                // Oggetto
                TextColumn::make('subject')
                    ->label('Oggetto')
                    ->limit(50)
                    ->tooltip(fn(InboundEmail $record) => $record->subject)
                    ->searchable()
                    ->weight(fn(InboundEmail $record) => $record->is_read ? 'normal' : 'bold'),  // Grassetto se non letta
                // Data Ricezione
                TextColumn::make('received_at')
                    ->label('Ricevuto il')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                // Indicatore Allegati
                IconColumn::make('has_attachments')
                    ->label('Allegati')
                    ->boolean()
                    ->getStateUsing(fn($record) => $record->getMedia('attachments')->isNotEmpty())
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('')
                    ->color('warning'),
            ])
            ->filters([
                // Filtro Rapido: Solo da leggere
                Filter::make('is_read')
                    ->label('Stato Lettura'),
                //    ->placeholder('Tutte le email')
                //   ->trueLabel('Già lette')
                //  ->falseLabel('Da leggere'),
                // Filtro per Canale/Mandante
                SelectFilter::make('canale')
                    ->relationship('canale', 'username')
                    ->label('Casella Email'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Leggi')
                    ->color('primary'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // Azione massiva per segnare come lette
                    BulkAction::make('mark_read')
                        ->label('Segna come lette')
                        ->icon('heroicon-o-envelope-open')
                        ->action(fn($records) => $records->each->update(['is_read' => true])),
                ]),
            ]);
    }
}
