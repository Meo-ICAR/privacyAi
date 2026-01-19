<?php

namespace App\Filament\Resources\MisuraSicurezzas\Pages;

use App\Filament\Resources\MisuraSicurezzas\MisuraSicurezzaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMisuraSicurezzas extends ListRecords
{
    protected static string $resource = MisuraSicurezzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
