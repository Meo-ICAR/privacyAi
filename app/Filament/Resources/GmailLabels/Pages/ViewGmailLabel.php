<?php

namespace App\Filament\Resources\GmailLabels\Pages;

use App\Filament\Resources\GmailLabels\GmailLabelResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGmailLabel extends ViewRecord
{
    protected static string $resource = GmailLabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('sync_mandante')
                ->label('Sincronizza Mandante')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    $this->record->updateMandanteFromDomain();
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Sincronizzazione Completata')
                        ->body('Il mandante è stato assegnato automaticamente se possibile.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione tenterà di assegnare automaticamente il mandante basandosi sul dominio.')
                ->visible(fn () => $this->record->dominio && !$this->record->mandante_id),
            
            \Filament\Actions\Action::make('view_in_gmail')
                ->label('Apri in Gmail')
                ->icon('heroicon-o-link')
                ->url('https://gmail.com')
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->type === 'user'),
        ];
    }
}
