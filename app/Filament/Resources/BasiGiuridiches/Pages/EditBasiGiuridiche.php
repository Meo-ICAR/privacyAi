<?php

namespace App\Filament\Resources\BasiGiuridiches\Pages;

use App\Filament\Resources\BasiGiuridiches\BasiGiuridicheResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBasiGiuridiche extends EditRecord
{
    protected static string $resource = BasiGiuridicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
