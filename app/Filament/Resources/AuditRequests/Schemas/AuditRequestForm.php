<?php

namespace App\Filament\Resources\AuditRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuditRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('mandataria_id')
                    ->relationship('mandataria', 'ragione_sociale')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('titolo')
                    ->required(),
                DatePicker::make('data_inizio')
                    ->required(),
                Select::make('stato')
                    ->options([
            'aperto' => 'Aperto',
            'in_corso' => 'In corso',
            'completato' => 'Completato',
            'archiviato' => 'Archiviato',
        ])
                    ->default('aperto')
                    ->required(),
            ]);
    }
}
