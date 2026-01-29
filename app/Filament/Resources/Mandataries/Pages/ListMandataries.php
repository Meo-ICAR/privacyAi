<?php

namespace App\Filament\Resources\Mandataries\Pages;

use App\Filament\Resources\Mandataries\MandatarieResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

use App\Imports\MandatarieImport;
use Eightynine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;

class ListMandataries extends ListRecords
{
    protected static string $resource = MandatarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->label('Importa Mandatarie')
                ->color('success')
                // Specifichi semplicemente la classe di importazione
                ->use(MandatarieImport::class)
                // Opzionale: mostra una notifica personalizzata
                ->successNotificationTitle('Importazione completata con successo!'),
            CreateAction::make(),
        ];
    }
}
