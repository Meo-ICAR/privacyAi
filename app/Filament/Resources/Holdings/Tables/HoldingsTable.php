<?php

namespace App\Filament\Resources\Holdings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class HoldingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('logo', 'thumb')),
                TextColumn::make('ragione_sociale')
                    ->searchable()
                    ->sortable()
                    ->description('Nome del Gruppo o Holding'),
                TextColumn::make('p_iva')
                    ->label('P. IVA')
                    ->searchable(),
                TextColumn::make('codice_gruppo')
                    ->searchable()
                    ->description('Codice reportistica'),
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
                ]),
            ])
            ->bulkActions([
                BulkAction::make('clone_to_mandatarie')
                    ->label('Clona in Mandatarie')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Collection $records) {
                        $count = 0;

                        foreach ($records as $holding) {
                            try {
                                Mandatarie::firstOrCreate(
                                    [
                                        'ragione_sociale' => $holding->ragione_sociale,
                                        'p_iva' => $holding->p_iva,
                                        'holding_id' => $holding->id,
                                    ],
                                    [
                                        'is_active' => true,
                                        'mandante_id' => auth()->user()->mandante_id,
                                        // Add other required fields for Mandatarie
                                    ]
                                );
                                $count++;
                            } catch (\Exception $e) {
                                // Log error if needed
                                \Log::error('Error cloning holding to mandatarie: ' . $e->getMessage());
                            }
                        }
                        return Notification::make()
                            ->title('Operazione completata')
                            ->body("$count holding clonate come mandatarie con successo!")
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Clona Holding in Mandatarie')
                    ->modalDescription('Sei sicuro di voler clonare le holding selezionate come mandatarie?')
                    ->modalButton('Sì, clona'),
                BulkAction::make('copy_to_fornitori')
                    ->label('Crea come Fornitore')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Collection $records) {
                        foreach ($records as $holding) {
                            Fornitore::firstOrCreate(
                                [
                                    'ragione_sociale' => $holding->ragione_sociale,
                                    'p_iva' => $holding->p_iva,
                                    'holding_id' => $holding->id,
                                ],
                                [
                                    'tipo' => 'Fornitore',
                                    'is_active' => true,
                                    'mandante_id' => auth()->user()->mandante_id,
                                    // Add other default fields as needed
                                ]
                            );
                        }

                        return Notification::make()
                            ->title('Operazione completata')
                            ->body('Holding copiate come fornitori con successo!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Copia Holding in Fornitori')
                    ->modalDescription('Sei sicuro di voler copiare le holding selezionate come fornitori?')
                    ->modalButton('Sì, copia'),
                // ... other bulk actions ...
            ]);
    }
}
