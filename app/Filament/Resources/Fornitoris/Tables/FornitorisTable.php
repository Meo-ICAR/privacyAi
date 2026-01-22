<?php

namespace App\Filament\Resources\Fornitoris\Tables;

use App\Models\AuditFornitori;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FornitorisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ragione_sociale')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('p_iva')
                    ->label('P. IVA')
                    ->searchable(),
                TextColumn::make('responsabile_trattamento')
                    ->limit(20),
                TextColumn::make('locazione_dati')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'UE' => 'success',
                        'USA' => 'warning',
                        'Extra-UE' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('mansione.nome')
                    ->label('Ruolo'),
                TextColumn::make('holding.ragione_sociale')
                    ->label('Holding')
                    ->sortable(),
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
                    BulkAction::make('audit')
                        ->label('AUDIT')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            foreach ($records as $record) {
                                AuditFornitori::updateOrCreate(
                                    [
                                        'fornitore_id' => $record->id,
                                        'anno_riferimento' => now()->year,
                                    ],
                                    [
                                        'mandante_id' => $record->mandante_id,
                                        'stato' => 'Pianificato',
                                    ]
                                );
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
