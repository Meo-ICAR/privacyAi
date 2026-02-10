<?php

namespace App\Filament\Resources\DataBreachResource\Pages;

use App\Filament\Resources\DataBreachResource;
use Filament\Resources\Pages\ListRecords;

class ListDataBreaches extends ListRecords
{
    protected static string $resource = DataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export_report')
                ->label('Esporta Report')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    // You could add export logic here
                    // return Excel::download(new DataBreachesExport, 'violazioni_dati.xlsx');
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Report Esportato')
                        ->body('Il report delle violazioni dati è stato generato con successo.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione esporterà un report completo di tutte le violazioni dati.'),
        ];
    }
}
