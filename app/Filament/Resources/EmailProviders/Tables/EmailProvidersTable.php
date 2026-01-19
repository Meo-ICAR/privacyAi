<?php

namespace App\Filament\Resources\EmailProviders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmailProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('display_name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('icon')
                    ->searchable(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('imap_host')
                    ->searchable(),
                TextColumn::make('imap_port')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('imap_encryption')
                    ->searchable(),
                TextColumn::make('pop3_host')
                    ->searchable(),
                TextColumn::make('pop3_port')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pop3_encryption')
                    ->searchable(),
                TextColumn::make('smtp_host')
                    ->searchable(),
                TextColumn::make('smtp_port')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('smtp_encryption')
                    ->searchable(),
                IconColumn::make('smtp_auth_required')
                    ->boolean(),
                TextColumn::make('api_endpoint')
                    ->searchable(),
                TextColumn::make('api_version')
                    ->searchable(),
                TextColumn::make('oauth_client_id')
                    ->searchable(),
                TextColumn::make('oauth_client_secret')
                    ->searchable(),
                TextColumn::make('oauth_redirect_uri')
                    ->searchable(),
                TextColumn::make('timeout')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('verify_ssl')
                    ->boolean(),
                TextColumn::make('auth_type')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
