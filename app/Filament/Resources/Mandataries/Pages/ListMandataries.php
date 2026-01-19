<?php

namespace App\Filament\Resources\Mandataries\Pages;

use App\Filament\Resources\Mandataries\MandatarieResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMandataries extends ListRecords
{
    protected static string $resource = MandatarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
