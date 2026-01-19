<?php

namespace App\Filament\Resources\AuditSezionis\Pages;

use App\Filament\Resources\AuditSezionis\AuditSezioniResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAuditSezioni extends ViewRecord
{
    protected static string $resource = AuditSezioniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
