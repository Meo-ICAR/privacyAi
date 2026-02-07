<?php

namespace App\Filament\Resources\TrattamentoResource\Pages;

use App\Filament\Resources\TrattamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrattamentos extends ListRecords
{
    protected static string $resource = TrattamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
