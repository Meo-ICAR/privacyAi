<?php

namespace App\Filament\Resources\Fornitoris\Pages;

use App\Filament\Resources\Fornitoris\FornitoriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Imports\FornitoriImport;
use Eightynine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;


class ListFornitoris extends ListRecords
{
    protected static string $resource = FornitoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->label('Importa Fornitori')
                ->color('success')
                // Specifichi semplicemente la classe di importazione
                ->use(FornitoriImport::class)
                // Opzionale: mostra una notifica personalizzata
                ->successNotificationTitle('Importazione completata con successo!'),
            CreateAction::make(),
        ];
    }
}
