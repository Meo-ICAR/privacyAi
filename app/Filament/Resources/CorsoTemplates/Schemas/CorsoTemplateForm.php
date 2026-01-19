<?php

namespace App\Filament\Resources\CorsoTemplates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CorsoTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titolo')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Nome standard del percorso formativo'),
                Textarea::make('descrizione')
                    ->columnSpanFull()
                    ->helperText('Dettagli sugli argomenti trattati'),
                TextInput::make('validita_mesi')
                    ->required()
                    ->numeric()
                    ->default(12)
                    ->helperText('Periodo di validità del certificato prima del rinnovo'),
                Toggle::make('is_obbligatorio')
                    ->default(true)
                    ->helperText('Indica se il corso è richiesto per la compliance minima'),
            ]);
    }
}
