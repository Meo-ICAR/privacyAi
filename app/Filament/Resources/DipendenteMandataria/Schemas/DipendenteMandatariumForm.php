<?php

namespace App\Filament\Resources\DipendenteMandataria\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DipendenteMandatariumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('dipendente_id')
                    ->required(),
                TextInput::make('mandataria_id')
                    ->required(),
                DatePicker::make('data_autorizzazione')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
