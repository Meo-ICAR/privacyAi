<?php

namespace App\Filament\Resources\AuditFornitoris\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AuditFornitoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->required()
                    ->searchable(),
                Select::make('fornitore_id')
                    ->relationship('fornitore', 'ragione_sociale')
                    ->required()
                    ->searchable(),
                TextInput::make('anno_riferimento')
                    ->numeric()
                    ->required(),
                DatePicker::make('data_esecuzione'),
                Select::make('stato')
                    ->options([
                        'Pianificato' => 'Pianificato',
                        'In Corso' => 'In Corso',
                        'Completato' => 'Completato',
                        'Annullato' => 'Annullato',
                    ])
                    ->required()
                    ->default('Pianificato'),
                TextInput::make('punteggio_compliance')
                    ->numeric()
                    ->helperText('Punteggio da 0 a 100'),
                Textarea::make('note_generali')
                    ->columnSpanFull(),
                Select::make('eseguito_da')
                    ->relationship('user', 'name')
                    ->searchable(),
            ]);
    }
}
