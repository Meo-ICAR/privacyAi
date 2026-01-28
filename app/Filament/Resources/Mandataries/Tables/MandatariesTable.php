<?php

namespace App\Filament\Resources\Mandataries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MandatariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('logo')
                    // Usiamo la logica per prendere l'immagine convertita (thumb)
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('logo', 'thumb'))
                    ->height('250px')
                    ->width('100%'),
                TextColumn::make('ragione_sociale')
                    ->label('Mandataria')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->p_iva),
                TextColumn::make('titolare_trattamento')
                    ->searchable(),
                TextColumn::make('data_ricezione_nomina')
                    ->date()
                    ->sortable(),
                TextColumn::make('holding.ragione_sociale')
                    ->label('Holding')
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
