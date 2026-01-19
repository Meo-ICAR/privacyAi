<?php

namespace App\Filament\Resources\Filialis\Pages;

use App\Filament\Resources\Filialis\FilialiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFiliali extends ViewRecord
{
    protected static string $resource = FilialiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
