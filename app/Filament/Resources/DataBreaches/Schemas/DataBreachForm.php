<?php

namespace App\Filament\Resources\DataBreaches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DataBreachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mandante_id')
                    ->relationship('mandante', 'id')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                DateTimePicker::make('occurred_at')
                    ->required(),
                DateTimePicker::make('detected_at')
                    ->required(),
                Toggle::make('is_notified_authority')
                    ->required(),
                DateTimePicker::make('authority_notified_at'),
                Toggle::make('is_notified_subjects')
                    ->required(),
                DateTimePicker::make('subjects_notified_at'),
                Select::make('risk_level')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'])
                    ->default('low')
                    ->required(),
                Select::make('status')
                    ->options(['open' => 'Open', 'investigating' => 'Investigating', 'closed' => 'Closed'])
                    ->default('open')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
