<?php

namespace App\Filament\Resources\InboundEmails\Schemas;

use Filament\Schemas\Schema;

class InboundEmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                onents\TextInput::make('subject')->readOnly(),
                Forms\Components\TextInput::make('from_email')->readOnly(),
                // ...campi di base read-only

            ]);
    }
}
