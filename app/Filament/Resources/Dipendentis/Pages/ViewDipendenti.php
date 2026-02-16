<?php

namespace App\Filament\Resources\Dipendentis\Pages;

use App\Filament\Resources\Dipendentis\DipendentiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDipendenti extends ViewRecord
{
    protected static string $resource = DipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
