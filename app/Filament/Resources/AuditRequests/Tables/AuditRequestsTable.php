<?php

namespace App\Filament\Resources\AuditRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->sortable(),
                TextColumn::make('mandataria.ragione_sociale')
                    ->label('Mandataria')
                    ->searchable(),
                TextColumn::make('titolo')
                    ->searchable()
                    ->sortable()
                    ->helperText('Es: Audit Annuale Privacy 2026'),
                TextColumn::make('data_inizio')
                    ->date()
                    ->sortable(),
                TextColumn::make('stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aperto' => 'gray',
                        'in_corso' => 'warning',
                        'completato' => 'success',
                        'archiviato' => 'info',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
