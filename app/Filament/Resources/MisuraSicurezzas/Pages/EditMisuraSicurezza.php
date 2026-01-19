<?php

namespace App\Filament\Resources\MisuraSicurezzas\Pages;

use App\Filament\Resources\MisuraSicurezzas\MisuraSicurezzaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMisuraSicurezza extends EditRecord
{
    protected static string $resource = MisuraSicurezzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
