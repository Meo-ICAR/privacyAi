<?php

namespace App\Filament\Resources\Dipendentis\Pages;

use App\Filament\Resources\Dipendentis\DipendentiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDipendenti extends EditRecord
{
    protected static string $resource = DipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
