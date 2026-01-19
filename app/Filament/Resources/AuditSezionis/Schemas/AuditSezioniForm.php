<?php

namespace App\Filament\Resources\AuditSezionis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AuditSezioniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Es: Sicurezza Infrastrutturale'),
                Textarea::make('descrizione')
                    ->columnSpanFull(),
                TextInput::make('ordine')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
