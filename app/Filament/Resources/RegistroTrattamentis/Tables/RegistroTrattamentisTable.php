<?php

namespace App\Filament\Resources\RegistroTrattamentis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class RegistroTrattamentisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('versione')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('data_aggiornamento')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Autore')
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
