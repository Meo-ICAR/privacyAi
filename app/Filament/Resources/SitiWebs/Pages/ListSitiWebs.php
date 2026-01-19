<?php

namespace App\Filament\Resources\SitiWebs\Pages;

use App\Filament\Resources\SitiWebs\SitiWebResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSitiWebs extends ListRecords
{
    protected static string $resource = SitiWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
