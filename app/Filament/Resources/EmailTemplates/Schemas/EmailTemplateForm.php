<?php

namespace App\Filament\Resources\EmailTemplates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmailTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText("Es: 'scadenza-corso', 'nuova-fattura'"),
                TextInput::make('oggetto')
                    ->required()
                    ->maxLength(255),
                Textarea::make('corpo_markdown')
                    ->rows(10)
                    ->required()
                    ->columnSpanFull(),
                KeyValue::make('placeholders')
                    ->helperText('Lista dei tag disponibili'),
            ]);
    }
}
