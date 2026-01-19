<?php

namespace App\Filament\Resources\AuditExports;

use App\Filament\Resources\AuditExports\Pages\CreateAuditExport;
use App\Filament\Resources\AuditExports\Pages\EditAuditExport;
use App\Filament\Resources\AuditExports\Pages\ListAuditExports;
use App\Filament\Resources\AuditExports\Pages\ViewAuditExport;
use App\Filament\Resources\AuditExports\Schemas\AuditExportForm;
use App\Filament\Resources\AuditExports\Schemas\AuditExportInfolist;
use App\Filament\Resources\AuditExports\Tables\AuditExportsTable;
use App\Models\AuditExport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditExportResource extends Resource
{
    protected static ?string $model = AuditExport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AuditExportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditExportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditExportsTable::configure($table);
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
            'index' => ListAuditExports::route('/'),
            'create' => CreateAuditExport::route('/create'),
            'view' => ViewAuditExport::route('/{record}'),
            'edit' => EditAuditExport::route('/{record}/edit'),
        ];
    }
}
