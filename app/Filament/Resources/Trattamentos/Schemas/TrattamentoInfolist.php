<?php

namespace App\Filament\Resources\Trattamentos\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrattamentoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('mandante.id')
                    ->label('Mandante'),
                TextEntry::make('nome'),
                TextEntry::make('descrizione')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('finalita')
                    ->columnSpanFull(),
                TextEntry::make('categorie_interessati')
                    ->columnSpanFull(),
                TextEntry::make('base_giuridica')
                    ->columnSpanFull(),
                TextEntry::make('destinatari')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('trasferimenti_extra_ue')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('termini_conservazione')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('misure_sicurezza')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
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
