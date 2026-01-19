<?php

namespace App\Filament\Resources\Mandantis\Pages;

use App\Filament\Resources\Mandantis\MandantiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMandanti extends ViewRecord
{
    protected static string $resource = MandantiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
