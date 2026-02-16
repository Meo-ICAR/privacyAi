<?php

namespace App\Filament\Resources\SitiWebs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class SitiWebsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('nome_progetto')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->badge(),
                IconColumn::make('has_cookie_policy')
                    ->boolean(),
                IconColumn::make('has_privacy_policy')
                    ->boolean(),
                TextColumn::make('hosting_provider')
                    ->searchable(),
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
