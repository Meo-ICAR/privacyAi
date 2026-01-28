<?php

namespace App\Filament\Resources\Dipendentis\Tables;

use App\Models\Corso;
use App\Models\Mandatarie;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DipendentisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cognome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_aziendale')
                    ->searchable(),
                TextColumn::make('mansione.nome')
                    ->label('Mansione')
                    ->sortable(),
                TextColumn::make('filiale.nome')
                    ->label('Filiale')
                    ->sortable(),
                TextColumn::make('albo')
                    ->label('Albo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('data_iscrizione')
                    ->label('Iscrizione Albo')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('abbina')
                        ->label('ABBINA')
                        ->icon('heroicon-o-link')
                        ->form([
                            Select::make('mandataria_id')
                                ->label('Mandataria')
                                ->options(Mandatarie::pluck('ragione_sociale', 'id'))
                                ->required()
                                ->searchable(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->mandatarie()->attach($data['mandataria_id'], [
                                    'data_autorizzazione' => now(),
                                    'is_active' => true,
                                ]);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('formazione')
                        ->label('FORMAZIONE')
                        ->icon('heroicon-o-academic-cap')
                        ->form([
                            Select::make('corso_id')
                                ->label('Corso')
                                ->options(Corso::pluck('titolo', 'id'))
                                ->required()
                                ->searchable(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->corsi()->attach($data['corso_id']);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
