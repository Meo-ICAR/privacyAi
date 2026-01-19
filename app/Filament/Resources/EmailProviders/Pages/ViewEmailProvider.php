<?php

namespace App\Filament\Resources\EmailProviders\Pages;

use App\Filament\Resources\EmailProviders\EmailProviderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEmailProvider extends ViewRecord
{
    protected static string $resource = EmailProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
