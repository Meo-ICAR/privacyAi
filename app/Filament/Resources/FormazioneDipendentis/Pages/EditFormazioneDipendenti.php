<?php

namespace App\Filament\Resources\FormazioneDipendentis\Pages;

use App\Filament\Resources\FormazioneDipendentis\FormazioneDipendentiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFormazioneDipendenti extends EditRecord
{
    protected static string $resource = FormazioneDipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
