<?php

namespace App\Filament\Resources\BasiGiuridiches\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BasiGiuridicheForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('codice')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                Textarea::make('descrizione')
                    ->columnSpanFull(),
                TextInput::make('riferimento_normativo')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
