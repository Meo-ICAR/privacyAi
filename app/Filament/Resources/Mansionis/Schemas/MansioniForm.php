<?php

namespace App\Filament\Resources\Mansionis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MansioniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Esempio: Operatore Front-End, DPO, Sistemista'),
                Textarea::make('descrizione')
                    ->columnSpanFull()
                    ->helperText('Descrizione dei compiti rilevanti ai fini privacy'),
                Select::make('livello_rischio')
                    ->options([
                        'basso' => 'Basso',
                        'medio' => 'Medio',
                        'alto' => 'Alto',
                    ])
                    ->required()
                    ->default('basso')
                    ->helperText('Livello di autorizzazione suggerito'),
            ]);
    }
}
