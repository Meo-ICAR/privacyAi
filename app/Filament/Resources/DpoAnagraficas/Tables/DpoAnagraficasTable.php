<?php

namespace App\Filament\Resources\DpoAnagraficas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class DpoAnagraficasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('denominazione')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_ordinaria')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->searchable(),
                TextColumn::make('citta')
                    ->label('Città')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_persona_giuridica')
                    ->boolean()
                    ->label('Persona Giuridica'),
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
