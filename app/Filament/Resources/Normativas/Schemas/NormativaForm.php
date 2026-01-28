<?php

namespace App\Filament\Resources\Normativas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class NormativaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question Information')
                    ->description('Basic information about the compliance question')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('section')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('control_area')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Grid::make(1)
                            ->schema([
                                TextInput::make('question_en')
                                    ->required()
                                    ->maxLength(500)
                                    ->label('Question (English)'),
                                TextInput::make('question_it')
                                    ->required()
                                    ->maxLength(500)
                                    ->label('Question (Italian)'),
                            ]),
                    ]),
                
                Section::make('Compliance References')
                    ->description('ISO 27001:2022 and GDPR references')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('iso_27001_2022_reference')
                                    ->label('ISO 27001:2022 Reference')
                                    ->placeholder('e.g., A.5.1, Cl. 4.1'),
                                TextInput::make('gdpr_reference')
                                    ->label('GDPR Reference')
                                    ->placeholder('e.g., Art. 24, Art. 32'),
                            ]),
                    ]),
                
                Section::make('Assessment Details')
                    ->description('Assessment parameters and scoring')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('answer')
                                    ->options([
                                        'Y' => 'Yes',
                                        'N' => 'No', 
                                        'N.A.' => 'Not Applicable'
                                    ])
                                    ->label('Answer')
                                    ->placeholder('Select answer'),
                                TextInput::make('weight')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(3)
                                    ->default(1)
                                    ->label('Weight (1-3)'),
                                TextInput::make('score')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->label('Score'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('evidence_required')
                                    ->label('Evidence Required')
                                    ->placeholder('e.g., Security Policy document'),
                                Select::make('risk_level')
                                    ->options([
                                        'Low' => 'Low',
                                        'Medium' => 'Medium',
                                        'High' => 'High'
                                    ])
                                    ->required()
                                    ->default('Low')
                                    ->label('Risk Level'),
                            ]),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
