<?php

namespace App\Filament\Resources\ServiziDpos\Pages;

use App\Filament\Resources\ServiziDpos\ServiziDpoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiziDpo extends ViewRecord
{
    protected static string $resource = ServiziDpoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
