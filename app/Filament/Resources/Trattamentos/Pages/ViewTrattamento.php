<?php

namespace App\Filament\Resources\Trattamentos\Pages;

use App\Filament\Resources\Trattamentos\TrattamentoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrattamento extends ViewRecord
{
    protected static string $resource = TrattamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
