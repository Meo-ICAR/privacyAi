<?php

namespace App\Filament\Resources\AuditFornitoris\Pages;

use App\Filament\Resources\AuditFornitoris\AuditFornitoriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuditFornitoris extends ListRecords
{
    protected static string $resource = AuditFornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
