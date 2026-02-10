<?php

namespace App\Filament\Resources\DataBreaches\Pages;

use App\Filament\Resources\DataBreaches\DataBreachResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDataBreach extends ViewRecord
{
    protected static string $resource = DataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
