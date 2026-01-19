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
                    ->required(),
                Textarea::make('descrizione')
                    ->columnSpanFull(),
                TextInput::make('validita_mesi')
                    ->required()
                    ->numeric()
                    ->default(12),
                Toggle::make('is_obbligatorio')
                    ->required(),
            ]);
    }
}
