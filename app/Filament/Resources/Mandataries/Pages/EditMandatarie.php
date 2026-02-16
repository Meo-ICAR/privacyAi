<?php

namespace App\Filament\Resources\Mandataries\Pages;

use App\Filament\Resources\Mandataries\MandatarieResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMandatarie extends EditRecord
{
    protected static string $resource = MandatarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
