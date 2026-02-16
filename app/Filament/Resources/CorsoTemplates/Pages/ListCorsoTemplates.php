<?php

namespace App\Filament\Resources\CorsoTemplates\Pages;

use App\Filament\Resources\CorsoTemplates\CorsoTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCorsoTemplates extends ListRecords
{
    protected static string $resource = CorsoTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
