<?php

namespace App\Filament\Resources\CorsoTemplates\Pages;

use App\Filament\Resources\CorsoTemplates\CorsoTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCorsoTemplate extends ViewRecord
{
    protected static string $resource = CorsoTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
