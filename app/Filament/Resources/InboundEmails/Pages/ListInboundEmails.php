<?php

namespace App\Filament\Resources\InboundEmails\Pages;

use App\Filament\Resources\InboundEmails\InboundEmailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInboundEmails extends ListRecords
{
    protected static string $resource = InboundEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
