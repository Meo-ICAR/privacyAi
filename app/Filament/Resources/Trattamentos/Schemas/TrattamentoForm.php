<?php

namespace App\Filament\Resources\Trattamentos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TrattamentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'id')
                    ->required(),
                TextInput::make('nome')
                    ->required(),
                Textarea::make('descrizione')
                    ->columnSpanFull(),
                Textarea::make('finalita')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('categorie_interessati')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('base_giuridica')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('destinatari')
                    ->columnSpanFull(),
                Textarea::make('trasferimenti_extra_ue')
                    ->columnSpanFull(),
                Textarea::make('termini_conservazione')
                    ->columnSpanFull(),
                Textarea::make('misure_sicurezza')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
