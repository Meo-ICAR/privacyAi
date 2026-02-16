<?php

namespace App\Filament\Resources\AuditSezionis\Pages;

use App\Filament\Resources\AuditSezionis\AuditSezioniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuditSezionis extends ListRecords
{
    protected static string $resource = AuditSezioniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
