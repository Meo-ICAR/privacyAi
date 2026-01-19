<?php

namespace App\Filament\Resources\DpoAnagraficas\Pages;

use App\Filament\Resources\DpoAnagraficas\DpoAnagraficaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDpoAnagraficas extends ListRecords
{
    protected static string $resource = DpoAnagraficaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
