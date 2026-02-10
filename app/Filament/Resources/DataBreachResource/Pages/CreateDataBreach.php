<?php

namespace App\Filament\Resources\DataBreachResource\Pages;

use App\Filament\Resources\DataBreachResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataBreach extends CreateRecord
{
    protected static string $resource = DataBreachResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set detected_at if not provided
        if (!isset($data['detected_at'])) {
            $data['detected_at'] = now();
        }

        // Auto-set notification times if toggles are enabled
        if (isset($data['is_notified_authority']) && $data['is_notified_authority'] && !isset($data['authority_notified_at'])) {
            $data['authority_notified_at'] = now();
        }

        if (isset($data['is_notified_subjects']) && $data['is_notified_subjects'] && !isset($data['subjects_notified_at'])) {
            $data['subjects_notified_at'] = now();
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Send notifications if high/critical risk
        if (in_array($this->record->risk_level, ['high', 'critical'])) {
            // You could add notification logic here
            // Notification::send($this->record->mandante, new DataBreachNotification($this->record));
        }
    }
}
