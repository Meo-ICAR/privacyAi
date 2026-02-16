<?php

namespace App\Filament\Resources\CorsoTemplates\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CorsoTemplateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('titolo'),
                TextEntry::make('descrizione')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('validita_mesi')
                    ->numeric(),
                IconEntry::make('is_obbligatorio')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
