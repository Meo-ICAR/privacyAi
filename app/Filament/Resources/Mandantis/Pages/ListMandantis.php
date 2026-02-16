<?php

namespace App\Filament\Resources\Mandantis\Pages;

use App\Filament\Resources\Mandantis\MandantiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMandantis extends ListRecords
{
    protected static string $resource = MandantiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
