<?php

namespace App\Filament\Resources\CanaliEmails\Pages;

use App\Filament\Resources\CanaliEmails\CanaliEmailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCanaliEmails extends ListRecords
{
    protected static string $resource = CanaliEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
