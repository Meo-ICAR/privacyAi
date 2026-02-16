<?php

namespace App\Filament\Resources\Corsos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CorsoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titolo')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('data')
                    ->required(),
                Textarea::make('argomenti')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('luogo')
                    ->maxLength(255),
                TextInput::make('url')
                    ->url()
                    ->maxLength(255),
                Select::make('dipendenti')
                    ->multiple()
                    ->relationship('dipendenti', 'cognome')
                    ->label('Dipendenti Autorizzati')
                    ->preload()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->cognome} {$record->nome}"),
            ]);
    }
}
