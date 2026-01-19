<?php

namespace App\Filament\Resources\AuditSezionis;

use App\Filament\Resources\AuditSezionis\Pages\CreateAuditSezioni;
use App\Filament\Resources\AuditSezionis\Pages\EditAuditSezioni;
use App\Filament\Resources\AuditSezionis\Pages\ListAuditSezionis;
use App\Filament\Resources\AuditSezionis\Pages\ViewAuditSezioni;
use App\Filament\Resources\AuditSezionis\Schemas\AuditSezioniForm;
use App\Filament\Resources\AuditSezionis\Schemas\AuditSezioniInfolist;
use App\Filament\Resources\AuditSezionis\Tables\AuditSezionisTable;
use App\Models\AuditSezioni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditSezioniResource extends Resource
{
    protected static ?string $model = AuditSezioni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AuditSezioniForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditSezioniInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditSezionisTable::configure($table);
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
            'index' => ListAuditSezionis::route('/'),
            'create' => CreateAuditSezioni::route('/create'),
            'view' => ViewAuditSezioni::route('/{record}'),
            'edit' => EditAuditSezioni::route('/{record}/edit'),
        ];
    }
}
