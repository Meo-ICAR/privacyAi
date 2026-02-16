<?php

namespace App\Filament\Resources\MisuraSicurezzas\Pages;

use App\Filament\Resources\MisuraSicurezzas\MisuraSicurezzaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMisuraSicurezza extends ViewRecord
{
    protected static string $resource = MisuraSicurezzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
