<?php

namespace App\Filament\Resources\Mandataries\Pages;

use App\Filament\Resources\Mandataries\MandatarieResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMandatarie extends ViewRecord
{
    protected static string $resource = MandatarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
