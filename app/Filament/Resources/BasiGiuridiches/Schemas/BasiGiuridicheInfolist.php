<?php

namespace App\Filament\Resources\BasiGiuridiches\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BasiGiuridicheInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Base Giuridica')
                    ->schema([
                        TextEntry::make('nome'),
                        TextEntry::make('codice'),
                        TextEntry::make('riferimento_normativo'),
                        IconEntry::make('is_active')
                            ->boolean()
                            ->label('Attiva'),
                        TextEntry::make('descrizione')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
