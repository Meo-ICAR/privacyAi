<?php

namespace App\Filament\Resources\CorsoTemplates\Pages;

use App\Filament\Resources\CorsoTemplates\CorsoTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCorsoTemplate extends EditRecord
{
    protected static string $resource = CorsoTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
