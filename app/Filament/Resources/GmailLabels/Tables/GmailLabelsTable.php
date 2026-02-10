<?php

namespace App\Filament\Resources\GmailLabels\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GmailLabelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name', 'asc')
            ->columns([
                TextColumn::make('google_id')
                    ->label('Google ID')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                //  ->helperText('ID univoco di Google'),
                TextColumn::make('name')
                    ->label('Nome Label')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),
                //  ->helperText('Nome completo della label')
                TextColumn::make('dominio')
                    ->label('Dominio')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->formatStateUsing(fn($state) => $state ?: '—'),
                // ->helperText('Dominio associato'),
                BadgeColumn::make('type')
                    ->label('Tipo')
                    ->colors([
                        'success' => 'user',
                        'warning' => 'system',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'user' => 'User',
                        'system' => 'System',
                        default => $state,
                    }),
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($record) => $record->mandante ? $record->mandante->ragione_sociale : '—')
                    ->badge()
                    ->color(fn($record) => $record->mandante ? 'primary' : 'gray'),
                IconColumn::make('has_mandante')
                    ->label('Associato')
                    ->boolean()
                    ->getStateUsing(fn($record) => $record->mandante_id !== null)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Aggiornato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'user' => 'User',
                        'system' => 'System',
                    ]),
                Filter::make('has_dominio')
                    ->label('Con Dominio')
                    ->query(fn($query) => $query->whereNotNull('dominio')),
                Filter::make('has_mandante')
                    ->label('Con Mandante')
                    ->query(fn($query) => $query->whereNotNull('mandante_id')),
                Filter::make('without_mandante')
                    ->label('Senza Mandante')
                    ->query(fn($query) => $query->whereNull('mandante_id')),
                SelectFilter::make('mandante')
                    ->label('Mandante')
                    ->relationship('mandante', 'ragione_sociale')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->after(function ($record) {
                        // Auto-sync mandante from domain after edit
                        $record->updateMandanteFromDomain();
                    }),
                Action::make('sync_mandante')
                    ->label('Sincronizza Mandante')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function ($record) {
                        $record->updateMandanteFromDomain();
                    })
                    ->requiresConfirmation()
                    ->modalDescription('Questa azione tenterà di assegnare automaticamente il mandante basandosi sul dominio.')
                    ->visible(fn($record) => $record->dominio && !$record->mandante_id),
                Action::make('view_in_gmail')
                    ->label('Apri in Gmail')
                    ->icon('heroicon-o-link')
                    ->url(fn($record) => 'https://gmail.com')
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->type === 'user'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Action::make('bulk_sync_mandanti')
                        ->label('Sincronizza Mandanti')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->updateMandanteFromDomain();
                            });
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Questa azione tenterà di assegnare automaticamente i mandanti a tutte le label selezionate basandosi sul dominio.')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
