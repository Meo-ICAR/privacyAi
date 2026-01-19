<?php

namespace App\Filament\Resources\DocumentiTipos\Pages;

use App\Filament\Resources\DocumentiTipos\DocumentiTipoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentiTipo extends EditRecord
{
    protected static string $resource = DocumentiTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
