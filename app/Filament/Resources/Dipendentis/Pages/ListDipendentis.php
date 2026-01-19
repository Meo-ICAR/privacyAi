<?php

namespace App\Filament\Resources\Dipendentis\Pages;

use App\Filament\Resources\Dipendentis\DipendentiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDipendentis extends ListRecords
{
    protected static string $resource = DipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
