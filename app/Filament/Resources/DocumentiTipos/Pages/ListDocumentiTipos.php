<?php

namespace App\Filament\Resources\DocumentiTipos\Pages;

use App\Filament\Resources\DocumentiTipos\DocumentiTipoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentiTipos extends ListRecords
{
    protected static string $resource = DocumentiTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
