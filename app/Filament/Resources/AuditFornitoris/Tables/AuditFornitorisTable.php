<?php

namespace App\Filament\Resources\AuditFornitoris\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class AuditFornitorisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->sortable(),
                TextColumn::make('fornitore.ragione_sociale')
                    ->label('Fornitore')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('anno_riferimento')
                    ->sortable(),
                TextColumn::make('stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pianificato' => 'gray',
                        'In Corso' => 'warning',
                        'Completato' => 'success',
                        'Annullato' => 'danger',
                    }),
                TextColumn::make('punteggio_compliance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('eseguito_da.name')
                    ->label('Auditor'),
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
