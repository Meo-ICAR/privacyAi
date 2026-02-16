<?php

namespace App\Filament\Resources\BasiGiuridiches\Pages;

use App\Filament\Resources\BasiGiuridiches\BasiGiuridicheResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBasiGiuridiche extends ViewRecord
{
    protected static string $resource = BasiGiuridicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
