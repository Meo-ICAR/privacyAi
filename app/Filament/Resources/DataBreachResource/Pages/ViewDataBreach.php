<?php

namespace App\Filament\Resources\DataBreachResource\Pages;

use App\Filament\Resources\DataBreachResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDataBreach extends ViewRecord
{
    protected static string $resource = DataBreachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('notify_authority')
                ->label('Notifica Autorità')
                ->icon('heroicon-o-bell')
                ->color('warning')
                ->action(function () {
                    $this->record->update([
                        'is_notified_authority' => true,
                        'authority_notified_at' => now(),
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Autorità Notificata')
                        ->body('La violazione è stata segnata come notificata all\'autorità di controllo.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione segna la violazione come notificata all\'autorità.')
                ->visible(fn () => !$this->record->is_notified_authority),
            
            \Filament\Actions\Action::make('notify_subjects')
                ->label('Notifica Interessati')
                ->icon('heroicon-o-users')
                ->color('info')
                ->action(function () {
                    $this->record->update([
                        'is_notified_subjects' => true,
                        'subjects_notified_at' => now(),
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Interessati Notificati')
                        ->body('La violazione è stata segnata come notificata agli interessati.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione segna la violazione come notificata agli interessati.')
                ->visible(fn () => !$this->record->is_notified_subjects),
            
            \Filament\Actions\Action::make('generate_report')
                ->label('Genera Report')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->action(function () {
                    // You could add PDF generation logic here
                    \Filament\Notifications\Notification::make()
                        ->title('Report Generato')
                        ->body('Il report dettagliato della violazione è stato generato.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalDescription('Questa azione genera un report dettagliato della violazione.'),
        ];
    }
}
