<?php

namespace App\Filament\Resources\CanaliEmails\Pages;

use App\Filament\Resources\CanaliEmails\CanaliEmailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCanaliEmail extends EditRecord
{
    protected static string $resource = CanaliEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
