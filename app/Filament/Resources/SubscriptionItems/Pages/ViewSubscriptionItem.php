<?php

namespace App\Filament\Resources\SubscriptionItems\Pages;

use App\Filament\Resources\SubscriptionItems\SubscriptionItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSubscriptionItem extends ViewRecord
{
    protected static string $resource = SubscriptionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
