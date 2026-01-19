<?php

namespace App\Filament\Resources\AuditRequests;

use App\Filament\Resources\AuditRequests\Pages\CreateAuditRequest;
use App\Filament\Resources\AuditRequests\Pages\EditAuditRequest;
use App\Filament\Resources\AuditRequests\Pages\ListAuditRequests;
use App\Filament\Resources\AuditRequests\Pages\ViewAuditRequest;
use App\Filament\Resources\AuditRequests\Schemas\AuditRequestForm;
use App\Filament\Resources\AuditRequests\Schemas\AuditRequestInfolist;
use App\Filament\Resources\AuditRequests\Tables\AuditRequestsTable;
use App\Models\AuditRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditRequestResource extends Resource
{
    protected static ?string $model = AuditRequest::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    public static function form(Schema $schema): Schema
    {
        return AuditRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuditRequests::route('/'),
            'create' => CreateAuditRequest::route('/create'),
            'view' => ViewAuditRequest::route('/{record}'),
            'edit' => EditAuditRequest::route('/{record}/edit'),
        ];
    }
}
