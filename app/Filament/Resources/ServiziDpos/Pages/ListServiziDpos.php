<?php

namespace App\Filament\Resources\ServiziDpos\Pages;

use App\Filament\Resources\ServiziDpos\ServiziDpoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiziDpos extends ListRecords
{
    protected static string $resource = ServiziDpoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
