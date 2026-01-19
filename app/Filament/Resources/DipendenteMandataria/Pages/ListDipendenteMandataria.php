<?php

namespace App\Filament\Resources\DipendenteMandataria\Pages;

use App\Filament\Resources\DipendenteMandataria\DipendenteMandatariumResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDipendenteMandataria extends ListRecords
{
    protected static string $resource = DipendenteMandatariumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
