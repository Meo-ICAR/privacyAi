<?php

namespace App\Filament\Resources\EmailProviders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmailProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('display_name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('icon'),
                TextInput::make('color'),
                TextInput::make('imap_host'),
                TextInput::make('imap_port')
                    ->numeric(),
                TextInput::make('imap_encryption'),
                TextInput::make('pop3_host'),
                TextInput::make('pop3_port')
                    ->numeric(),
                TextInput::make('pop3_encryption'),
                TextInput::make('smtp_host'),
                TextInput::make('smtp_port')
                    ->numeric(),
                TextInput::make('smtp_encryption'),
                Toggle::make('smtp_auth_required')
                    ->required(),
                TextInput::make('api_endpoint'),
                TextInput::make('api_version'),
                TextInput::make('oauth_client_id'),
                TextInput::make('oauth_client_secret'),
                TextInput::make('oauth_redirect_uri'),
                TextInput::make('oauth_scopes'),
                TextInput::make('timeout')
                    ->required()
                    ->numeric()
                    ->default(30),
                Toggle::make('verify_ssl')
                    ->required(),
                TextInput::make('auth_type')
                    ->required()
                    ->default('password'),
                TextInput::make('settings'),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('setup_instructions')
                    ->columnSpanFull(),
            ]);
    }
}
