<?php

namespace App\Filament\Resources\InboundEmails\Pages;

use App\Filament\Resources\InboundEmails\InboundEmailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInboundEmail extends CreateRecord
{
    protected static string $resource = InboundEmailResource::class;
}
