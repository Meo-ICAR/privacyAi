<?php

namespace App\Filament\Resources\AziendaTipos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class AziendaTipoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
            ]);
    }
}
