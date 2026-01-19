<?php

namespace App\Filament\Resources\DipendenteMandataria\Pages;

use App\Filament\Resources\DipendenteMandataria\DipendenteMandatariaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDipendenteMandataria extends ListRecords
{
    protected static string $resource = DipendenteMandatariaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
