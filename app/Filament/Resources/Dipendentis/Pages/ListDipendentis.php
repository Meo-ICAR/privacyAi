<?php

namespace App\Filament\Resources\Dipendentis\Pages;

use App\Filament\Resources\Dipendentis\DipendentiResource;
use App\Imports\DipendentiImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ListDipendentis extends ListRecords
{
    protected static string $resource = DipendentiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Importa da Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->action(function (array $data) {
                    $import = new DipendentiImport(auth()->user()->mandante_id);
                    Excel::import($import, $data['file']);

                    $this->dispatch('imported');
                })
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->required()
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->downloadable()
                        ->directory('imports')
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend('dipendenti-import-'),
                        ),
                ])
                ->modalHeading('Importa Dipendenti')
                ->modalDescription('Carica un file Excel con i dati dei dipendenti')
                ->modalSubmitActionLabel('Importa')
                ->successNotificationTitle('Importazione completata con successo!'),
            CreateAction::make(),
        ];
    }
}
