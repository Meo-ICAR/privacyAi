<?php

namespace App\Filament\Resources\AuditExports\Pages;

use App\Filament\Resources\AuditExports\AuditExportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuditExport extends CreateRecord
{
    protected static string $resource = AuditExportResource::class;
}
