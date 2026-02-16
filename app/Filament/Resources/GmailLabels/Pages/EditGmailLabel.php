<?php

namespace App\Filament\Resources\GmailLabels\Pages;

use App\Filament\Resources\GmailLabels\GmailLabelResource;
use Filament\Resources\Pages\EditRecord;

class EditGmailLabel extends EditRecord
{
    protected static string $resource = GmailLabelResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-assign mandante from domain if auto_assign is enabled
        if (isset($data['auto_assign_mandante']) && $data['auto_assign_mandante'] && !empty($data['dominio'])) {
            // The model will handle the auto-assignment in its saving/boot process
        }

        // Remove the auto_assign field as it's not a database column
        unset($data['auto_assign_mandante']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Auto-assign mandante from domain after save
        $this->record->updateMandanteFromDomain();
    }
}
