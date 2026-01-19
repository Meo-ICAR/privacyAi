<?php

namespace App\Filament\Resources\AuditExports\Pages;

use App\Filament\Resources\AuditExports\AuditExportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAuditExport extends ViewRecord
{
    protected static string $resource = AuditExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
