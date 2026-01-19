<?php

namespace App\Filament\Resources\BasiGiuridiches\Pages;

use App\Filament\Resources\BasiGiuridiches\BasiGiuridicheResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBasiGiuridiches extends ListRecords
{
    protected static string $resource = BasiGiuridicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
