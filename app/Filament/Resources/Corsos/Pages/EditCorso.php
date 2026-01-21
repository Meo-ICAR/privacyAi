<?php

namespace App\Filament\Resources\Corsos\Pages;

use App\Filament\Resources\CorsoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorso extends EditRecord
{
    protected static string $resource = CorsoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
