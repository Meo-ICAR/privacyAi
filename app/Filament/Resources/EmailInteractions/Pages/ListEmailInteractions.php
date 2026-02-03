<?php

namespace App\Filament\Resources\EmailInteractions\Pages;

use App\Filament\Resources\EmailInteractions\EmailInteractionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmailInteractions extends ListRecords
{
    protected static string $resource = EmailInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
