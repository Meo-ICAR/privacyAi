<?php

namespace App\Filament\Resources\FormazioneDipendentis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class FormazioneDipendentisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dipendente.cognome')
                    ->label('Dipendente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('corsoTemplate.titolo')
                    ->label('Corso')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('data_conseguimento')
                    ->date()
                    ->sortable(),
                TextColumn::make('data_scadenza')
                    ->date()
                    ->sortable(),
                TextColumn::make('stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'valido' => 'success',
                        'in_scadenza' => 'warning',
                        'scaduto' => 'danger',
                    }),
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
