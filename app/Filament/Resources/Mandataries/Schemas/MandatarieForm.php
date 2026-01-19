<?php

namespace App\Filament\Resources\Mandataries\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class MandatarieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->required()
                    ->searchable()
                    ->helperText('Il tenant (Mandante) censisce i propri clienti (Mandatarie)'),
                TextInput::make('ragione_sociale')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Titolare del Trattamento (Cliente del Call Center)'),
                TextInput::make('p_iva')
                    ->label('P. IVA')
                    ->required()
                    ->maxLength(11),
                TextInput::make('website')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Sito web aziendale'),
                TextInput::make('landingpage')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Landing page per mandataria'),
                DatePicker::make('data_ricezione_nomina')
                    ->required()
                    ->helperText('Data in cui la Mandataria ha nominato il Mandante come Responsabile'),
                TextInput::make('titolare_trattamento')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Titolare del Trattamento'),
                TextInput::make('email_referente')
                    ->email()
                    ->maxLength(255)
                    ->helperText('Contatto primario per comunicazioni privacy'),
            ]);
    }
}
