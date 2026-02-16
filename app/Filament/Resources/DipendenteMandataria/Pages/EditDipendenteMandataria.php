<?php

namespace App\Filament\Resources\DipendenteMandataria\Pages;

use App\Filament\Resources\DipendenteMandataria\DipendenteMandatariaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDipendenteMandataria extends EditRecord
{
    protected static string $resource = DipendenteMandatariaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
