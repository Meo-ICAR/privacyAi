<?php

namespace App\Filament\Resources\AuditSezionis\Pages;

use App\Filament\Resources\AuditSezionis\AuditSezioniResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditSezioni extends EditRecord
{
    protected static string $resource = AuditSezioniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
