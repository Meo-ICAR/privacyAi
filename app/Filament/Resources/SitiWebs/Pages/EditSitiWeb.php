<?php

namespace App\Filament\Resources\SitiWebs\Pages;

use App\Filament\Resources\SitiWebs\SitiWebResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSitiWeb extends EditRecord
{
    protected static string $resource = SitiWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
