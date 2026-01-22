<?php

namespace App\Filament\Resources\InboundEmails\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InboundEmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subject')->readOnly(),
                TextInput::make('from_email')->readOnly(),
                // ...campi di base read-only
            ]);
    }
}
