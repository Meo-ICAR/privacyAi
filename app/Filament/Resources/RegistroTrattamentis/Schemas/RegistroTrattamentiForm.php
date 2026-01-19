<?php

namespace App\Filament\Resources\RegistroTrattamentis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class RegistroTrattamentiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->required()
                    ->searchable(),
                TextInput::make('versione')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Es: v2026.01.19.001'),
                DateTimePicker::make('data_aggiornamento')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->helperText("Chi ha generato/causato l'aggiornamento"),
                KeyValue::make('payload')
                    ->columnSpanFull()
                    ->helperText('Snapshot completo dei dati'),
            ]);
    }
}
