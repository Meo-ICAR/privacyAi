<?php

namespace App\Filament\Resources\DpoAnagraficas\Pages;

use App\Filament\Resources\DpoAnagraficas\DpoAnagraficaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDpoAnagrafica extends EditRecord
{
    protected static string $resource = DpoAnagraficaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
