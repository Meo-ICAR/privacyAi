<?php

namespace App\Filament\Resources\GmailLabels\Pages;

use App\Filament\Resources\GmailLabels\GmailLabelResource;
use Filament\Resources\Pages\ListRecords;

class ListGmailLabels extends ListRecords
{
    protected static string $resource = GmailLabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('sync_all_mandanti')
                ->label('Sincronizza Tutti i Mandanti')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    \App\Models\GmailLabel::whereNull('mandante_id')
                        ->whereNotNull('dominio')
                        ->each(function ($label) {
                            $label->updateMandanteFromDomain();
                        });
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Sincronizzazione Completata')
                        ->body('I mandanti sono stati assegnati automaticamente dove possibile.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione tenterà di assegnare automaticamente i mandanti a tutte le label senza mandante che hanno un dominio.'),
        ];
    }
}
