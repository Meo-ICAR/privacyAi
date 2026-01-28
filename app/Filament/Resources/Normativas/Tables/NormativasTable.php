<?php

namespace App\Filament\Resources\Normativas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class NormativasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('control_area')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn (mixed $state): string => $state ?? ''),
                TextColumn::make('question_it')
                    ->searchable()
                    ->limit(50)
                    ->label('Question (IT)')
                    ->tooltip(fn (mixed $state): string => $state ?? ''),
                TextColumn::make('iso_27001_2022_reference')
                    ->searchable()
                    ->badge()
                    ->color('success')
                    ->label('ISO 27001'),
                TextColumn::make('gdpr_reference')
                    ->searchable()
                    ->badge()
                    ->color('warning')
                    ->label('GDPR'),
                BadgeColumn::make('answer')
                    ->colors([
                        'success' => 'Y',
                        'danger' => 'N',
                        'gray' => 'N.A.',
                    ]),
                TextColumn::make('evidence_required')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn (mixed $state): string => $state ?? '')
                    ->label('Evidence'),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (mixed $state): string => match($state) {
                        1 => 'gray',
                        2 => 'warning', 
                        3 => 'danger',
                    }),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                BadgeColumn::make('risk_level')
                    ->colors([
                        'success' => 'Low',
                        'warning' => 'Medium',
                        'danger' => 'High',
                    ]),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('section')
                    ->options([
                        'General' => 'General',
                        'Governance' => 'Governance',
                        'Access Control' => 'Access Control',
                        'IT Security' => 'IT Security',
                        'Data Protection' => 'Data Protection',
                        'Incident Management' => 'Incident Management',
                        'Business Continuity' => 'Business Continuity',
                        'Suppliers' => 'Suppliers',
                        'Compliance' => 'Compliance',
                        'Risk' => 'Risk',
                        'Declaration' => 'Declaration',
                    ]),
                SelectFilter::make('answer')
                    ->options([
                        'Y' => 'Yes',
                        'N' => 'No',
                        'N.A.' => 'Not Applicable',
                    ]),
                SelectFilter::make('risk_level')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
