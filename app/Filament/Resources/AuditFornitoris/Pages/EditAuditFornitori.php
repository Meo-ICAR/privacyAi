<?php

namespace App\Filament\Resources\AuditFornitoris\Pages;

use App\Filament\Resources\AuditFornitoris\AuditFornitoriResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditFornitori extends EditRecord
{
    protected static string $resource = AuditFornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
