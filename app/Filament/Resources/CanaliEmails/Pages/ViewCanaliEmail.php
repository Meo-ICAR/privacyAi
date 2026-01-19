<?php

namespace App\Filament\Resources\CanaliEmails\Pages;

use App\Filament\Resources\CanaliEmails\CanaliEmailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCanaliEmail extends ViewRecord
{
    protected static string $resource = CanaliEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
