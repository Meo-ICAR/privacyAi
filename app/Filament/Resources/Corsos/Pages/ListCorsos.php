<?php

namespace App\Filament\Resources\Corsos\Pages;

use App\Filament\Resources\Corsos\CorsoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorsos extends ListRecords
{
    protected static string $resource = CorsoResource::class;

    protected array $tableActions = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
