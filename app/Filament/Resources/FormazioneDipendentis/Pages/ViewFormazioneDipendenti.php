<?php

namespace App\Filament\Resources\FormazioneDipendentis\Pages;

use App\Filament\Resources\FormazioneDipendentis\FormazioneDipendentiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFormazioneDipendenti extends ViewRecord
{
    protected static string $resource = FormazioneDipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
