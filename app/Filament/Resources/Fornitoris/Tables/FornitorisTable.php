<?php

namespace App\Filament\Resources\Fornitoris\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class FornitorisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ragione_sociale')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('p_iva')
                    ->label('P. IVA')
                    ->searchable(),
                TextColumn::make('responsabile_trattamento')
                    ->limit(20),
                TextColumn::make('locazione_dati')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'UE' => 'success',
                        'USA' => 'warning',
                        'Extra-UE' => 'danger',
                    }),
                TextColumn::make('mansione.nome')
                    ->label('Ruolo'),
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
