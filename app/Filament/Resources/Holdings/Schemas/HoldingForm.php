<?php

namespace App\Filament\Resources\Holdings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HoldingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Holding')
                    ->schema([
                        TextInput::make('ragione_sociale')
                            ->label('Ragione Sociale')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('codice_gruppo', Str::slug($state))),
                        TextInput::make('p_iva')
                            ->label('Partita IVA')
                            ->required()
                            ->maxLength(20),
                        TextInput::make('codice_gruppo')
                            ->label('Codice Gruppo')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('holdings/logos')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
