<?php

namespace App\Filament\Resources\InboundEmails\Pages;

use App\Filament\Resources\InboundEmails\InboundEmailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;


class ViewInboundEmail extends ViewRecord
{
    protected static string $resource = InboundEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //   EditAction::make(),
        ];
    }
}
