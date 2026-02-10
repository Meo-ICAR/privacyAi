<?php

namespace App\Filament\Resources\DataBreachResource\Pages;

use App\Filament\Resources\DataBreachResource;
use Filament\Resources\Pages\EditRecord;

class EditDataBreach extends EditRecord
{
    protected static string $resource = DataBreachResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-set notification times if toggles are enabled
        if (isset($data['is_notified_authority']) && $data['is_notified_authority'] && !isset($data['authority_notified_at'])) {
            $data['authority_notified_at'] = now();
        }

        if (isset($data['is_notified_subjects']) && $data['is_notified_subjects'] && !isset($data['subjects_notified_at'])) {
            $data['subjects_notified_at'] = now();
        }

        // Clear notification times if toggles are disabled
        if (isset($data['is_notified_authority']) && !$data['is_notified_authority']) {
            $data['authority_notified_at'] = null;
        }

        if (isset($data['is_notified_subjects']) && !$data['is_notified_subjects']) {
            $data['subjects_notified_at'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Send notifications if risk level changed to high/critical
        if ($this->record->wasChanged('risk_level') && in_array($this->record->risk_level, ['high', 'critical'])) {
            // You could add notification logic here
            // Notification::send($this->record->mandante, new DataBreachNotification($this->record));
        }
    }
}
