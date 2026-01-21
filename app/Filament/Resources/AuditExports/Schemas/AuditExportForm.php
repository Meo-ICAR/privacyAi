<?php

namespace App\Filament\Resources\AuditExports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuditExportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tipo_report')
                    ->required(),
                DateTimePicker::make('generato_il')
                    ->required(),
                TextInput::make('user_id')
                    ->required(),
            ]);
    }
}
