<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrattamentoResource\Pages;
use App\Models\Trattamento;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrattamentoResource extends Resource
{
    protected static ?string $model = Trattamento::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR';

    protected static ?string $navigationLabel = 'ROPA';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informazioni Generali')
                    ->schema([
                        Forms\Components\Select::make('mandante_id')
                            ->relationship('mandante', 'ragione_sociale')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome Trattamento')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Es: Gestione Payroll, Marketing Diretto'),
                        Forms\Components\Textarea::make('descrizione')
                            ->label('Descrizione')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Dettagli GDPR')
                    ->schema([
                        Forms\Components\Textarea::make('finalita')
                            ->label('Finalità del Trattamento')
                            ->required()
                            ->helperText('Art. 30 GDPR')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('categorie_interessati')
                            ->label('Categorie di Interessati')
                            ->required()
                            ->helperText('Es: Dipendenti, Clienti, Fornitori')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('categorieDati')
                            ->relationship('categorieDati', 'nome')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Categorie di Dati Personali'),
                        Forms\Components\Textarea::make('base_giuridica')
                            ->label('Base Giuridica')
                            ->required()
                            ->helperText('Art. 6 GDPR: Consenso, Contratto, Obbligo Legale, etc.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Destinatari e Trasferimenti')
                    ->schema([
                        Forms\Components\Select::make('mandatarie')
                            ->relationship('mandatarie', 'ragione_sociale')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Responsabili del Trattamento'),
                        Forms\Components\Textarea::make('destinatari')
                            ->label('Altri Destinatari')
                            ->helperText('Soggetti a cui vengono comunicati i dati'),
                        Forms\Components\Textarea::make('trasferimenti_extra_ue')
                            ->label('Trasferimenti Extra-UE')
                            ->helperText('Paesi terzi e garanzie adeguate'),
                    ])->columns(2),

                Forms\Components\Section::make('Conservazione e Sicurezza')
                    ->schema([
                        Forms\Components\Textarea::make('termini_conservazione')
                            ->label('Termini di Conservazione')
                            ->helperText('Periodo di conservazione dei dati'),
                        Forms\Components\Textarea::make('misure_sicurezza')
                            ->label('Misure di Sicurezza')
                            ->helperText('Misure tecniche e organizzative'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mandante.ragione_sociale')
                    ->label('Mandante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Trattamento')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finalita')
                    ->label('Finalità')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('mandante_id')
                    ->relationship('mandante', 'ragione_sociale')
                    ->label('Mandante'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Attivo'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTrattamentos::route('/'),
            'create' => Pages\CreateTrattamento::route('/create'),
            'view' => Pages\ViewTrattamento::route('/{record}'),
            'edit' => Pages\EditTrattamento::route('/{record}/edit'),
        ];
    }
}
