<?php

namespace App\Filament\Resources\Holdings\Schemas;

use App\Models\Holding;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HoldingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('ragione_sociale'),
                TextEntry::make('p_iva'),
                TextEntry::make('codice_gruppo')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Holding $record): bool => $record->trashed()),
            ]);
    }
}
