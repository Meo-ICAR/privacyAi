<?php

namespace App\Filament\Resources\EmailProviders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmailProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('display_name'),
                TextEntry::make('type'),
                TextEntry::make('icon')
                    ->placeholder('-'),
                TextEntry::make('color')
                    ->placeholder('-'),
                TextEntry::make('imap_host')
                    ->placeholder('-'),
                TextEntry::make('imap_port')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('imap_encryption')
                    ->placeholder('-'),
                TextEntry::make('pop3_host')
                    ->placeholder('-'),
                TextEntry::make('pop3_port')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pop3_encryption')
                    ->placeholder('-'),
                TextEntry::make('smtp_host')
                    ->placeholder('-'),
                TextEntry::make('smtp_port')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('smtp_encryption')
                    ->placeholder('-'),
                IconEntry::make('smtp_auth_required')
                    ->boolean(),
                TextEntry::make('api_endpoint')
                    ->placeholder('-'),
                TextEntry::make('api_version')
                    ->placeholder('-'),
                TextEntry::make('oauth_client_id')
                    ->placeholder('-'),
                TextEntry::make('oauth_client_secret')
                    ->placeholder('-'),
                TextEntry::make('oauth_redirect_uri')
                    ->placeholder('-'),
                TextEntry::make('timeout')
                    ->numeric(),
                IconEntry::make('verify_ssl')
                    ->boolean(),
                TextEntry::make('auth_type'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('setup_instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
