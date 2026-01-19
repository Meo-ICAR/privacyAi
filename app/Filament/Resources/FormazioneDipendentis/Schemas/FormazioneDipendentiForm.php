<?php

namespace App\Filament\Resources\FormazioneDipendentis\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FormazioneDipendentiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->required()
                    ->searchable(),
                Select::make('dipendente_id')
                    ->relationship('dipendente', 'cognome')
                    ->required()
                    ->searchable(),
                Select::make('corso_template_id')
                    ->relationship('corsoTemplate', 'titolo')
                    ->required()
                    ->searchable(),
                DatePicker::make('data_conseguimento')
                    ->required()
                    ->helperText('Data effettiva di superamento del test'),
                DatePicker::make('data_scadenza')
                    ->required()
                    ->helperText('Calcolo automatico: data_conseguimento + template.validita_mesi'),
                Select::make('stato')
                    ->options([
                        'valido' => 'Valido',
                        'in_scadenza' => 'In Scadenza',
                        'scaduto' => 'Scaduto',
                    ])
                    ->default('valido')
                    ->required()
                    ->helperText('Status: valido, in_scadenza, scaduto'),
            ]);
    }
}
