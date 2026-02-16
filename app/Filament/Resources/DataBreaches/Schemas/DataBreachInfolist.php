<?php

namespace App\Filament\Resources\DataBreaches\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DataBreachInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('mandante.id')
                    ->label('Mandante'),
                TextEntry::make('description'),
                TextEntry::make('occurred_at')
                    ->dateTime(),
                TextEntry::make('detected_at')
                    ->dateTime(),
                IconEntry::make('is_notified_authority')
                    ->boolean(),
                TextEntry::make('authority_notified_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('is_notified_subjects')
                    ->boolean(),
                TextEntry::make('subjects_notified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('risk_level')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
