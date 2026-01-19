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
                    ->required(),
                TextInput::make('oggetto')
                    ->required(),
                Textarea::make('corpo_markdown')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('placeholders')
                    ->required(),
            ]);
    }
}
