<?php

namespace App\Filament\Resources\DataBreachResource\Pages;

use App\Filament\Resources\DataBreachResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDataBreaches extends ManageRecords
{
    protected static string $resource = DataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
