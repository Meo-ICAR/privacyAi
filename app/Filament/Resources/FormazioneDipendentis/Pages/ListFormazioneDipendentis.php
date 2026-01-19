<?php

namespace App\Filament\Resources\FormazioneDipendentis\Pages;

use App\Filament\Resources\FormazioneDipendentis\FormazioneDipendentiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormazioneDipendentis extends ListRecords
{
    protected static string $resource = FormazioneDipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
