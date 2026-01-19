<?php

namespace App\Filament\Resources\Mansionis\Pages;

use App\Filament\Resources\Mansionis\MansioniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMansionis extends ListRecords
{
    protected static string $resource = MansioniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
