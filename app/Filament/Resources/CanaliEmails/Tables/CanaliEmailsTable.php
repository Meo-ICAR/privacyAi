<?php

namespace App\Filament\Resources\CanaliEmails\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class CanaliEmailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Nome Canale')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->sortable(),
                TextColumn::make('emailProvider.name')
                    ->label('Provider')
                    ->badge(),
                TextColumn::make('last_sync_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Ultimo Sync'),
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
