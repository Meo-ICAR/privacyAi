<?php

namespace App\Filament\Resources\Mandantis\RelationManagers;

use App\Models\GmailLabel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GmailLabelsRelationManager extends RelationManager
{
    protected static string $relationship = 'gmailLabels';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('google_id')
                    ->label('Google ID')
                    ->required()
                    ->maxLength(255)
                    ->helperText('ID univoco della label da Google'),
                Forms\Components\TextInput::make('name')
                    ->label('Nome Label')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Nome completo della label (es. PRIVACY/THUNDER)'),
                Forms\Components\TextInput::make('dominio')
                    ->label('Dominio')
                    ->maxLength(255)
                    ->helperText('Dominio associato alla label (es. innova-tech.cloud)'),
                Forms\Components\Select::make('type')
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
                Tables\Columns\TextColumn::make('google_id')
                    ->label('Google ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Label')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dominio')
                    ->label('Dominio')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipo')
                    ->colors([
                        'success' => 'user',
                        'warning' => 'system',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'user' => 'User',
                        'system' => 'System',
                    ]),
                Tables\Filters\Filter::make('has_dominio')
                    ->label('Con Dominio')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('dominio')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record) {
                        // Auto-assign mandante from domain if possible
                        $record->updateMandanteFromDomain();
                    }),
                Tables\Actions\Action::make('sync_from_domain')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->after(function ($record) {
                        // Re-sync mandante from domain after edit
                        $record->updateMandanteFromDomain();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
