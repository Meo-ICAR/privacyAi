<?php

namespace App\Filament\Resources\Mandataries\Pages;

use App\Filament\Resources\Mandataries\MandatarieResource;
use App\Models\AuditRequest;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewMandatarie extends ViewRecord
{
    protected static string $resource = MandatarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('audit')
                ->label('AUDIT')
                ->icon('heroicon-o-clipboard-document-check')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    $record = $this->getRecord();

                    AuditRequest::create([
                        'mandataria_id' => $record->id,
                        'mandante_id' => $record->mandante_id,
                        'titolo' => 'Audit ' . $record->ragione_sociale . ' ' . now()->format('Y'),
                        'data_inizio' => now(),
                        'stato' => 'aperto',
                    ]);

                    Notification::make()
                        ->title('Richiesta Audit creata con successo')
                        ->success()
                        ->send();
                }),
        ];
    }
}
