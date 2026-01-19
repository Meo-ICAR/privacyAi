<?php

namespace App\Filament\Resources\Filialis\Pages;

use App\Filament\Resources\Filialis\FilialiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFiliali extends EditRecord
{
    protected static string $resource = FilialiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
