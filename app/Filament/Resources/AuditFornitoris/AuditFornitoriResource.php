<?php

namespace App\Filament\Resources\AuditFornitoris;

use App\Filament\Resources\AuditFornitoris\Pages\CreateAuditFornitori;
use App\Filament\Resources\AuditFornitoris\Pages\EditAuditFornitori;
use App\Filament\Resources\AuditFornitoris\Pages\ListAuditFornitoris;
use App\Filament\Resources\AuditFornitoris\Pages\ViewAuditFornitori;
use App\Filament\Resources\AuditFornitoris\Schemas\AuditFornitoriForm;
use App\Filament\Resources\AuditFornitoris\Schemas\AuditFornitoriInfolist;
use App\Filament\Resources\AuditFornitoris\Tables\AuditFornitorisTable;
use App\Models\AuditFornitori;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditFornitoriResource extends Resource
{
    protected static ?string $model = AuditFornitori::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    public static function form(Schema $schema): Schema
    {
        return AuditFornitoriForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditFornitoriInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditFornitorisTable::configure($table);
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
            'index' => ListAuditFornitoris::route('/'),
            'create' => CreateAuditFornitori::route('/create'),
            'view' => ViewAuditFornitori::route('/{record}'),
            'edit' => EditAuditFornitori::route('/{record}/edit'),
        ];
    }
}
