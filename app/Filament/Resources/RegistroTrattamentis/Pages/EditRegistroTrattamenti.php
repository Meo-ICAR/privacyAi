<?php

namespace App\Filament\Resources\RegistroTrattamentis\Pages;

use App\Filament\Resources\RegistroTrattamentis\RegistroTrattamentiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistroTrattamenti extends EditRecord
{
    protected static string $resource = RegistroTrattamentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
