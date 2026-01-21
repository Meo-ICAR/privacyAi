<?php

namespace App\Filament\Resources\Corsos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CorsosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titolo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('data')
                    ->date()
                    ->sortable(),
                TextColumn::make('luogo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label('Link Corso')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->placeholder('-'),
                TextColumn::make('created_at')
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
