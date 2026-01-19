<?php

namespace App\Filament\Resources\AuditRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AuditRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('mandante_id'),
                TextEntry::make('mandataria_id'),
                TextEntry::make('titolo'),
                TextEntry::make('data_inizio')
                    ->date(),
                TextEntry::make('stato')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
