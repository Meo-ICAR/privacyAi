<?php

namespace App\Filament\Resources\Dipendentis\Pages;

use App\Filament\Resources\Dipendentis\DipendentiResource;
use App\Imports\DipendentiImport;
use Eightynine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDipendentis extends ListRecords
{
    protected static string $resource = DipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->label('Importa Dipendenti')
                ->color('success')
                // Specifichi semplicemente la classe di importazione
                ->use(DipendentiImport::class)
                // Opzionale: mostra una notifica personalizzata
                ->successNotificationTitle('Importazione completata con successo!'),
            CreateAction::make(),
        ];
    }
}
