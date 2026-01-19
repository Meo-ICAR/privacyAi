<?php

namespace App\Filament\Resources\DocumentiTipos\Pages;

use App\Filament\Resources\DocumentiTipos\DocumentiTipoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDocumentiTipo extends ViewRecord
{
    protected static string $resource = DocumentiTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
