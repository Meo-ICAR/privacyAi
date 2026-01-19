<?php

namespace App\Filament\Resources\MisuraSicurezzas\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MisuraSicurezzaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codice')
                    ->maxLength(255),
                TextInput::make('nome')
                    ->maxLength(255),
                TextInput::make('tipo')
                    ->maxLength(255),
                TextInput::make('area')
                    ->maxLength(255),
                Textarea::make('descrizione')
                    ->columnSpanFull()
                    ->helperText('Dettagli su come la misura è applicata'),
            ]);
    }
}
