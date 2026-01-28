<?php

namespace App\Filament\Resources\Normativas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Schema;

class NormativaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('section')
                                    ->badge()
                                    ->color('primary'),
                                TextEntry::make('control_area')
                                    ->columnSpanFull(),
                            ]),
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('question_en')
                                    ->label('Question (English)')
                                    ->columnSpanFull(),
                                TextEntry::make('question_it')
                                    ->label('Question (Italian)')
                                    ->columnSpanFull(),
                            ]),
                    ]),
                
                Section::make('Compliance References')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('iso_27001_2022_reference')
                                    ->label('ISO 27001:2022 Reference')
                                    ->badge()
                                    ->color('success')
                                    ->placeholder('-'),
                                TextEntry::make('gdpr_reference')
                                    ->label('GDPR Reference')
                                    ->badge()
                                    ->color('warning')
                                    ->placeholder('-'),
                            ]),
                    ]),
                
                Section::make('Assessment Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('answer')
                                    ->badge()
                                    ->color(fn (mixed $state): string => match($state) {
                                        'Y' => 'success',
                                        'N' => 'danger',
                                        'N.A.' => 'gray',
                                        default => 'gray',
                                    })
                                    ->placeholder('-'),
                                TextEntry::make('weight')
                                    ->numeric()
                                    ->badge()
                                    ->color(fn (mixed $state): string => match($state) {
                                        1 => 'gray',
                                        2 => 'warning',
                                        3 => 'danger',
                                        default => 'gray',
                                    })
                                    ->label('Weight (1-3)'),
                                TextEntry::make('score')
                                    ->numeric()
                                    ->badge()
                                    ->color('info'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('evidence_required')
                                    ->label('Evidence Required')
                                    ->placeholder('-'),
                                TextEntry::make('risk_level')
                                    ->badge()
                                    ->color(fn (mixed $state): string => match($state) {
                                        'Low' => 'success',
                                        'Medium' => 'warning',
                                        'High' => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                        TextEntry::make('notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Timestamps')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
