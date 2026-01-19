<?php

namespace App\Filament\Resources\AuditFornitoris\Pages;

use App\Filament\Resources\AuditFornitoris\AuditFornitoriResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAuditFornitori extends ViewRecord
{
    protected static string $resource = AuditFornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
