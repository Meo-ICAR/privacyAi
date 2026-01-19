<?php

namespace App\Filament\Resources\RegistroTrattamentis\Pages;

use App\Filament\Resources\RegistroTrattamentis\RegistroTrattamentiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistroTrattamenti extends ViewRecord
{
    protected static string $resource = RegistroTrattamentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
