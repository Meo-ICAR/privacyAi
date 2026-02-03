<?php

namespace App\Filament\Resources\EmailInteractions\Pages;

use App\Filament\Resources\EmailInteractions\EmailInteractionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEmailInteraction extends EditRecord
{
    protected static string $resource = EmailInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
