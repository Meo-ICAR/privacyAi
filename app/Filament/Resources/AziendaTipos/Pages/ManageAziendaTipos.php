<?php

namespace App\Filament\Resources\AziendaTipos\Pages;

use App\Filament\Resources\AziendaTipos\AziendaTipoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAziendaTipos extends ManageRecords
{
    protected static string $resource = AziendaTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
