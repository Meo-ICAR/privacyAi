<?php

namespace App\Filament\Resources\DipendenteMandataria\Pages;

use App\Filament\Resources\DipendenteMandataria\DipendenteMandatariaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDipendenteMandataria extends ViewRecord
{
    protected static string $resource = DipendenteMandatariaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
