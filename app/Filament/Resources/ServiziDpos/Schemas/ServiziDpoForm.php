<?php

namespace App\Filament\Resources\ServiziDpos\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ServiziDpoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Es: Assistenza Audit, Canone DPO Annuale'),
                TextInput::make('stripe_price_id')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('prezzo')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                Select::make('tipo')
                    ->options([
                        'una_tantum' => 'Una Tantum',
                        'ricorrente' => 'Ricorrente',
                    ])
                    ->required(),
            ]);
    }
}
