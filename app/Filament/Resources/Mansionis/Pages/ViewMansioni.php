<?php

namespace App\Filament\Resources\Mansionis\Pages;

use App\Filament\Resources\Mansionis\MansioniResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMansioni extends ViewRecord
{
    protected static string $resource = MansioniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
