<?php

namespace App\Filament\Resources\Mandataries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class MandatariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ragione_sociale')
                    ->label('Mandataria')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->p_iva),
                TextColumn::make('titolare_trattamento')
                    ->searchable(),
                TextColumn::make('data_ricezione_nomina')
                    ->date()
                    ->sortable(),
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
