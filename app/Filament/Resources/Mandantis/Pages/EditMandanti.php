<?php

namespace App\Filament\Resources\Mandantis\Pages;

use App\Filament\Resources\Mandantis\MandantiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMandanti extends EditRecord
{
    protected static string $resource = MandantiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
