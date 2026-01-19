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
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('stripe_product')
                    ->required()
                    ->maxLength(255),
                TextInput::make('stripe_price')
                    ->required()
                    ->maxLength(255),
                TextInput::make('quantity')
                    ->numeric(),
                TextInput::make('meter_event_name')
                    ->maxLength(255),
            ]);
    }
}
