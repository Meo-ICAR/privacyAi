<?php

namespace App\Filament\Resources\DocumentiTipos\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class DocumentiTipoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Es: Nomina Art. 28, Registro Trattamenti'),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('categoria')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Es: Privacy, Formazione, Audit'),
                Textarea::make('descrizione')
                    ->columnSpanFull(),
                Toggle::make('is_obbligatorio')
                    ->default(false),
            ]);
    }
}
