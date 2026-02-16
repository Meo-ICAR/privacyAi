<?php

namespace App\Filament\Resources\Mandantis\RelationManagers;

use App\Models\GmailLabel;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;


class GmailLabelsRelationManager extends RelationManager
{
    protected static string $relationship = 'gmailLabels';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('google_id')
                    ->label('Google ID')
                    ->required()
                    ->maxLength(255)
                    ->helperText('ID univoco della label da Google'),
                TextInput::make('name')
                    ->label('Nome Label')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Nome completo della label (es. PRIVACY/THUNDER)'),
                TextInput::make('dominio')
                    ->label('Dominio')
                    ->maxLength(255)
                    ->helperText('Dominio associato alla label (es. innova-tech.cloud)'),
                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'user' => 'User',
                        'system' => 'System',
                    ])
                    ->required()
                    ->default('user')
                    ->helperText('Tipo di label Gmail'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('google_id')
                    ->label('Google ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->label('Nome Label')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dominio')
                    ->label('Dominio')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'success' => 'user',
                        'warning' => 'system',
                    ]),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'user' => 'User',
                        'system' => 'System',
                    ]),
                Filter::make('has_dominio')
                    ->label('Con Dominio')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('dominio')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->after(function ($record) {
                        // Auto-assign mandante from domain if possible
                        $record->updateMandanteFromDomain();
                    }),
                Action::make('sync_from_domain')
                    ->label('Sincronizza da Dominio')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function () {
                        $this->getOwnerRecord()->gmailLabels()
                            ->whereNull('mandante_id')
                            ->each(function ($label) {
                                $label->updateMandanteFromDomain();
                            });
                    })
                    ->requiresConfirmation()
                    ->modalDescription(' Questa azione aggiornerà il mandante_id per tutte le label senza mandante assegnato, basandosi sul dominio.'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->after(function ($record) {
                        // Re-sync mandante from domain after edit
                        $record->updateMandanteFromDomain();
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
