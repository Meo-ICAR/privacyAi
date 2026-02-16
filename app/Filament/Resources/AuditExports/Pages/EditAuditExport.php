<?php

namespace App\Filament\Resources\AuditExports\Pages;

use App\Filament\Resources\AuditExports\AuditExportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditExport extends EditRecord
{
    protected static string $resource = AuditExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
