<?php

namespace App\Filament\Resources\AuditExports\Pages;

use App\Filament\Resources\AuditExports\AuditExportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuditExports extends ListRecords
{
    protected static string $resource = AuditExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
