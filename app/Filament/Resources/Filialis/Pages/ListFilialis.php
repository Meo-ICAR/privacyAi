<?php

namespace App\Filament\Resources\Filialis\Pages;

use App\Filament\Resources\Filialis\FilialiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilialis extends ListRecords
{
    protected static string $resource = FilialiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
