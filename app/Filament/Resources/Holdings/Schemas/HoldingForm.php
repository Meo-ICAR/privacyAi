<?php

namespace App\Filament\Resources\Holdings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HoldingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ragione_sociale')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Nome del Gruppo o Holding'),
                TextInput::make('p_iva')
                    ->required()
                    ->maxLength(11)
                    ->unique(ignoreRecord: true),
                TextInput::make('codice_gruppo')
                    ->maxLength(255)
                    ->helperText('Codice per reportistica aggregata'),
            ]);
    }
}
