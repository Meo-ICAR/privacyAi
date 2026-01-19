<?php

namespace App\Filament\Resources\AuditRequests\Pages;

use App\Filament\Resources\AuditRequests\AuditRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuditRequest extends CreateRecord
{
    protected static string $resource = AuditRequestResource::class;
}
