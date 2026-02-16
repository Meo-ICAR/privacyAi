<?php

namespace App\Filament\Resources\SitiWebs\Pages;

use App\Filament\Resources\SitiWebs\SitiWebResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSitiWeb extends ViewRecord
{
    protected static string $resource = SitiWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
