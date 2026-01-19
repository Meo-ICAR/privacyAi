<?php

namespace App\Filament\Resources\DipendenteMandataria\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DipendenteMandatariaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('dipendente_id')
                    ->relationship('dipendente', 'cognome')
                    ->required()
                    ->searchable(),
                Select::make('mandataria_id')
                    ->relationship('mandataria', 'ragione_sociale')
                    ->required()
                    ->searchable(),
                DatePicker::make('data_autorizzazione')
                    ->required()
                    ->helperText('Data in cui il dipendente è stato autorizzato a operare su questa specifica Mandataria'),
                Toggle::make('is_active')
                    ->default(true)
                    ->required()
                    ->helperText('Indica se il dipendente opera ancora con questa Mandataria'),
            ]);
    }
}
