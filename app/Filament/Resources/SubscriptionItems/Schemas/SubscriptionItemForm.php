<?php

namespace App\Filament\Resources\SubscriptionItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriptionItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subscription_id')
                    ->required()
                    ->numeric(),
                TextInput::make('stripe_id')
                    ->required(),
                TextInput::make('stripe_product')
                    ->required(),
                TextInput::make('stripe_price')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric(),
                TextInput::make('meter_event_name'),
            ]);
    }
}
