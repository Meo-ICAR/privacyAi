<?php

namespace App\Filament\Resources\EmailInteractions\Pages;

use App\Filament\Resources\EmailInteractions\EmailInteractionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEmailInteraction extends ViewRecord
{
    protected static string $resource = EmailInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
