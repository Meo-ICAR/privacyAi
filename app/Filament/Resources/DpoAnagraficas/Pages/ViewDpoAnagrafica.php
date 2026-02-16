<?php

namespace App\Filament\Resources\DpoAnagraficas\Pages;

use App\Filament\Resources\DpoAnagraficas\DpoAnagraficaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDpoAnagrafica extends ViewRecord
{
    protected static string $resource = DpoAnagraficaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
