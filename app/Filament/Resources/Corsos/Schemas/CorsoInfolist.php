<?php

namespace App\Filament\Resources\Corsos\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CorsoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dettagli Corso')
                    ->schema([
                        TextEntry::make('titolo'),
                        TextEntry::make('data')
                            ->date(),
                        TextEntry::make('luogo')
                            ->placeholder('-'),
                        TextEntry::make('url')
                            ->label('URL Corso')
                            ->placeholder('-'),
                        TextEntry::make('argomenti')
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make('Partecipanti')
                    ->schema([
                        TextEntry::make('dipendenti.cognome')
                            ->label('Dipendenti')
                            ->listWithLineBreaks()
                            ->bulleted(),
                    ]),
            ]);
    }
}
