<?php

namespace App\Filament\Resources\Mansionis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class MansionisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Mansioni $record): string => $record->descrizione ?? ''),
                TextColumn::make('livello_rischio')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'basso' => 'success',
                        'medio' => 'warning',
                        'alto' => 'danger',
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
