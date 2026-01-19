<?php

namespace App\Filament\Resources\DipendenteMandataria\Pages;

use App\Filament\Resources\DipendenteMandataria\DipendenteMandatariumResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDipendenteMandatarium extends ViewRecord
{
    protected static string $resource = DipendenteMandatariumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
