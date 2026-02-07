<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataBreachResource\Pages;
use App\Models\DataBreach;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataBreachResource extends Resource
{
    protected static ?string $model = DataBreach::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Dettagli Violazione')
                            ->schema([
                                Forms\Components\Select::make('mandante_id')
                                    ->relationship('mandante', 'ragione_sociale')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Descrizione')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\DateTimePicker::make('occurred_at')
                                    ->label('Data Accaduto')
                                    ->required(),
                                Forms\Components\DateTimePicker::make('detected_at')
                                    ->label('Data Rilevamento')
                                    ->required(),
                                Forms\Components\Select::make('risk_level')
                                    ->label('Livello di Rischio')
                                    ->options([
                                        'low' => 'Basso',
                                        'medium' => 'Medio',
                                        'high' => 'Alto',
                                        'critical' => 'Critico',
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label('Stato')
                                    ->options([
                                        'open' => 'Aperto',
                                        'investigating' => 'In Indagine',
                                        'closed' => 'Chiuso',
                                    ])
                                    ->required()
                                    ->default('open'),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Notifiche')
                            ->schema([
                                Forms\Components\Toggle::make('is_notified_authority')
                                    ->label('Notifica Garante')
                                    ->live(),
                                Forms\Components\DateTimePicker::make('authority_notified_at')
                                    ->label('Data Notifica Garante')
                                    ->hidden(fn (Forms\Get $get) => !$get('is_notified_authority')),

                                Forms\Components\Toggle::make('is_notified_subjects')
                                    ->label('Notifica Interessati')
                                    ->live(),
                                Forms\Components\DateTimePicker::make('subjects_notified_at')
                                    ->label('Data Notifica Interessati')
                                    ->hidden(fn (Forms\Get $get) => !$get('is_notified_subjects')),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrizione')
                    ->limit(50),
                Tables\Columns\TextColumn::make('detected_at')
                    ->label('Rilevato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('risk_level')
                    ->label('Rischio')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'critical' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Aperto',
                        'investigating' => 'In Indagine',
                        'closed' => 'Chiuso',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDataBreaches::route('/'),
        ];
    }
}
