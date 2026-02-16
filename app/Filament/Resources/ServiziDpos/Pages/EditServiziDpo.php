<?php

namespace App\Filament\Resources\ServiziDpos\Pages;

use App\Filament\Resources\ServiziDpos\ServiziDpoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServiziDpo extends EditRecord
{
    protected static string $resource = ServiziDpoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
