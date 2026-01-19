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
                    ->required(),
                TextInput::make('p_iva')
                    ->required(),
                TextInput::make('codice_gruppo'),
            ]);
    }
}
