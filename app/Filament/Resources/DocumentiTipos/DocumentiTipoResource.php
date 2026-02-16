<?php

namespace App\Filament\Resources\DocumentiTipos;

use App\Filament\Resources\DocumentiTipos\Pages\CreateDocumentiTipo;
use App\Filament\Resources\DocumentiTipos\Pages\EditDocumentiTipo;
use App\Filament\Resources\DocumentiTipos\Pages\ListDocumentiTipos;
use App\Filament\Resources\DocumentiTipos\Pages\ViewDocumentiTipo;
use App\Filament\Resources\DocumentiTipos\Schemas\DocumentiTipoForm;
use App\Filament\Resources\DocumentiTipos\Schemas\DocumentiTipoInfolist;
use App\Filament\Resources\DocumentiTipos\Tables\DocumentiTiposTable;
use App\Models\DocumentiTipo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocumentiTipoResource extends Resource
{
    protected static ?string $model = DocumentiTipo::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return DocumentiTipoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DocumentiTipoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentiTiposTable::configure($table);
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
            'index' => ListDocumentiTipos::route('/'),
            'create' => CreateDocumentiTipo::route('/create'),
            'view' => ViewDocumentiTipo::route('/{record}'),
            'edit' => EditDocumentiTipo::route('/{record}/edit'),
        ];
    }
}
