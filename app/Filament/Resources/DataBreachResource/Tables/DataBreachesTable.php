<?php

namespace App\Filament\Resources\DataBreachResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DataBreachesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('occurred_at', 'desc')
            ->columns([
                TextColumn::make('description')
                    ->label('Descrizione')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn($record) => $record->description)
                    ->weight('medium'),
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('primary')
                    ->placeholder('Nessun mandante'),
                BadgeColumn::make('risk_level')
                    ->label('Rischio')
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                        'danger' => 'critical',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'low' => 'Basso',
                        'medium' => 'Medio',
                        'high' => 'Alto',
                        'critical' => 'Critico',
                        default => $state,
                    }),
                BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'danger' => 'open',
                        'warning' => 'investigating',
                        'success' => 'closed',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'open' => 'Aperto',
                        'investigating' => 'In Indagine',
                        'closed' => 'Chiuso',
                        default => $state,
                    }),
                TextColumn::make('occurred_at')
                    ->label('Data Violazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('is_notified_authority')
                    ->label('Autorità')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_notified_subjects')
                    ->label('Interessati')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('risk_level')
                    ->label('Livello di Rischio')
                    ->options([
                        'low' => 'Basso',
                        'medium' => 'Medio',
                        'high' => 'Alto',
                        'critical' => 'Critico',
                    ]),
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'open' => 'Aperto',
                        'investigating' => 'In Indagine',
                        'closed' => 'Chiuso',
                    ]),
                Filter::make('notified_authority')
                    ->label('Autorità Notificata')
                    ->query(fn($query) => $query->where('is_notified_authority', true)),
                Filter::make('notified_subjects')
                    ->label('Interessati Notificati')
                    ->query(fn($query) => $query->where('is_notified_subjects', true)),
                Filter::make('high_risk')
                    ->label('Rischio Alto/Critico')
                    ->query(fn($query) => $query->whereIn('risk_level', ['high', 'critical'])),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('notify_authority')
                    ->label('Notifica Autorità')
                    ->icon('heroicon-o-bell')
                    ->color('warning')
                    ->action(function ($record) {
                        $record->update([
                            'is_notified_authority' => true,
                            'authority_notified_at' => now(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalDescription("Questa azione segna la violazione come notificata all'autorità.")
                    ->visible(fn($record) => !$record->is_notified_authority),
                Action::make('notify_subjects')
                    ->label('Notifica Interessati')
                    ->icon('heroicon-o-users')
                    ->color('info')
                    ->action(function ($record) {
                        $record->update([
                            'is_notified_subjects' => true,
                            'subjects_notified_at' => now(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalDescription('Questa azione segna la violazione come notificata agli interessati.')
                    ->visible(fn($record) => !$record->is_notified_subjects),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Action::make('bulk_notify_authority')
                        ->label('Notifica Autorità')
                        ->icon('heroicon-o-bell')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'is_notified_authority' => true,
                                    'authority_notified_at' => now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalDescription("Questa azione segna le violazioni selezionate come notificate all'autorità.")
                        ->deselectRecordsAfterCompletion(),
                    Action::make('bulk_notify_subjects')
                        ->label('Notifica Interessati')
                        ->icon('heroicon-o-users')
                        ->color('info')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'is_notified_subjects' => true,
                                    'subjects_notified_at' => now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Questa azione segna le violazioni selezionate come notificate agli interessati.')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Nuova Violazione')
                    ->url(fn() => route('filament.admin.resources.data-breaches.create'))
                    ->icon('heroicon-o-plus'),
            ]);
    }
}
