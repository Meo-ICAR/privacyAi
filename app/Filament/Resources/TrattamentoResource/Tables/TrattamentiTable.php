<?php

namespace App\Filament\Resources\TrattamentoResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TrattamentiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('nome', 'asc')
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome Trattamento')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->nome),
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('primary')
                    ->placeholder('Nessun mandante'),
                TextColumn::make('finalita')
                    ->label('Finalità')
                    ->searchable()
                    ->limit(100)
                    ->tooltip(fn($record) => $record->finalita),
                TextColumn::make('categorie_interessati')
                    ->label('Categorie Interessati')
                    ->searchable()
                    ->limit(100)
                    ->tooltip(fn($record) => $record->categorie_interessati),
                TextColumn::make('base_giuridica')
                    ->label('Base Giuridica')
                    ->searchable()
                    ->limit(100)
                    ->tooltip(fn($record) => $record->base_giuridica),
                IconColumn::make('is_active')
                    ->label('Stato')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),
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
                Filter::make('active')
                    ->label('Solo Attivi')
                    ->query(fn($query) => $query->where('is_active', true)),
                Filter::make('inactive')
                    ->label('Solo Inattivi')
                    ->query(fn($query) => $query->where('is_active', false)),
                SelectFilter::make('mandante')
                    ->label('Mandante')
                    ->relationship('mandante', 'ragione_sociale')
                    ->searchable()
                    ->preload(),
                Filter::make('has_destinatari')
                    ->label('Con Destinatari')
                    ->query(fn($query) => $query->whereNotNull('destinatari')),
                Filter::make('extra_ue_transfers')
                    ->label('Trasferimenti Extra UE')
                    ->query(fn($query) => $query->whereNotNull('trasferimenti_extra_ue')),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('duplicate')
                    ->label('Duplica')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('warning')
                    ->action(function ($record) {
                        $newRecord = $record->replicate();
                        $newRecord->nome = $record->nome . ' (Copia)';
                        $newRecord->save();
                    })
                    ->requiresConfirmation()
                    ->modalDescription('Questa azione creerà una copia di questo trattamento.'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Action::make('bulk_deactivate')
                        ->label('Disattiva Selezionati')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Questa azione disattiverà i trattamenti selezionati.')
                        ->deselectRecordsAfterCompletion(),
                    Action::make('bulk_activate')
                        ->label('Attiva Selezionati')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Questa azione attiverà i trattamenti selezionati.')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Nuovo Trattamento')
                    ->url(fn() => route('filament.admin.resources.trattamenti.create'))
                    ->icon('heroicon-o-plus'),
            ]);
    }
}
