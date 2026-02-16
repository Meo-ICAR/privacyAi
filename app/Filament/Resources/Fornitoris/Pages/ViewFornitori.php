<?php

namespace App\Filament\Resources\Fornitoris\Pages;

use App\Filament\Resources\Fornitoris\FornitoriResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFornitori extends ViewRecord
{
    protected static string $resource = FornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
