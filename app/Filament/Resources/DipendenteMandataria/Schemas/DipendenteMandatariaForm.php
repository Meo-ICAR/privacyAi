<?php

namespace App\Filament\Resources\DipendenteMandataria\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

class DipendenteMandatariaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('dipendente_id')
                    ->relationship(
                        name: 'dipendente',
                        titleAttribute: 'cognome',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->whereHas('mandante', function ($q) {
                                $tenant = Filament::getTenant();
                                if ($tenant->holding_id) {
                                    $q->where('holding_id', $tenant->holding_id);
                                } else {
                                    $q->where('id', $tenant->id);
                                }
                            })
                            ->where('is_active', true)
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->cognome} {$record->nome} ({$record->mandante->ragione_sociale})")
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('mansione_id')
                    ->relationship('mansione', 'nome')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Mansione specifica del dipendente per questa Mandataria'),
                DatePicker::make('data_autorizzazione')
                    ->required()
                    ->helperText('Data in cui il dipendente è stato autorizzato a operare su questa specifica Mandataria'),
                Toggle::make('is_active')
                    ->default(true)
                    ->required()
                    ->helperText('Indica se il dipendente opera ancora con questa Mandataria'),
            ]);
    }
}
