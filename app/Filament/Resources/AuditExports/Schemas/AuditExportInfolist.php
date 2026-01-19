<?php

namespace App\Filament\Resources\AuditExports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AuditExportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('tipo_report'),
                TextEntry::make('generato_il')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('mandante_id'),
                TextEntry::make('user_id'),
                TextEntry::make('mandataria_id'),
            ]);
    }
}
