<?php

namespace App\Filament\Resources\DataBreaches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DataBreachesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('mandante.id')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('occurred_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('detected_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_notified_authority')
                    ->boolean(),
                TextColumn::make('authority_notified_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_notified_subjects')
                    ->boolean(),
                TextColumn::make('subjects_notified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('risk_level')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
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
