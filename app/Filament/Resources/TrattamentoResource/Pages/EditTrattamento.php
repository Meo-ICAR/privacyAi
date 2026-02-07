<?php

namespace App\Filament\Resources\TrattamentoResource\Pages;

use App\Filament\Resources\TrattamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrattamento extends EditRecord
{
    protected static string $resource = TrattamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
