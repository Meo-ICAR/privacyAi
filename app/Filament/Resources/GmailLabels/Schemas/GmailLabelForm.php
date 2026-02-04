<?php

namespace App\Filament\Resources\GmailLabels\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GmailLabelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Generali')
                    ->schema([
                        TextInput::make('google_id')
                            ->label('Google ID')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('ID univoco della label proveniente da Google (es. Label_1, INBOX)'),
                        TextInput::make('name')
                            ->label('Nome Label')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nome completo della label (es. PRIVACY/THUNDER)'),
                        TextInput::make('dominio')
                            ->label('Dominio')
                            ->maxLength(255)
                            ->placeholder('es. innova-tech.cloud')
                            ->helperText('Dominio associato alla label per l\'associazione automatica al mandante'),
                        Select::make('type')
                            ->label('Tipo Label')
                            ->options([
                                'user' => 'User (Creata dall\'utente)',
                                'system' => 'System (Di sistema)',
                            ])
                            ->required()
                            ->default('user')
                            ->helperText('Tipo di label Gmail'),
                    ])
                    ->columns(2),
                Section::make('Associazione Mandante')
                    ->schema([
                        Select::make('mandante_id')
                            ->label('Mandante')
                            ->relationship('mandante', 'ragione_sociale')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Mandante associato a questa label (verrà assegnato automaticamente dal dominio se lasciato vuoto)'),
                        Toggle::make('auto_assign_mandante')
                            ->label('Assegna Automaticamente Mandante')
                            ->default(true)
                            ->helperText('Assegna automaticamente il mandante basandosi sul dominio specificato')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if ($state && $get('dominio')) {
                                    // Auto-assign logic will be handled in the model
                                }
                            }),
                        Textarea::make('mandante_info')
                            ->label('Informazioni Mandante')
                            ->disabled()
                            ->rows(2)
                            ->default(function ($record) {
                                if (!$record || !$record->mandante) return 'Nessun mandante assegnato';
                                return "Mandante: {$record->mandante->ragione_sociale}\nWebsite: {$record->mandante->website}";
                            })
                            ->helperText('Informazioni sul mandante attualmente assegnato'),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),
                Section::make('Metadati')
                    ->schema([
                        TextInput::make('created_at')
                            ->label('Creato il')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => $state ? $state->format('d/m/Y H:i') : '')
                            ->helperText('Data e ora di creazione'),
                        TextInput::make('updated_at')
                            ->label('Aggiornato il')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => $state ? $state->format('d/m/Y H:i') : '')
                            ->helperText('Data e ora dell\'ultimo aggiornamento'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
