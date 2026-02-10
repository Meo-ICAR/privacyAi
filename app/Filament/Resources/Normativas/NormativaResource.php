<?php

namespace App\Filament\Resources\Normativas;

use App\Filament\Resources\Normativas\Pages\CreateNormativa;
use App\Filament\Resources\Normativas\Pages\EditNormativa;
use App\Filament\Resources\Normativas\Pages\ListNormativas;
use App\Filament\Resources\Normativas\Pages\ViewNormativa;
use App\Filament\Resources\Normativas\Schemas\NormativaForm;
use App\Filament\Resources\Normativas\Schemas\NormativaInfolist;
use App\Filament\Resources\Normativas\Tables\NormativasTable;
use App\Models\Normativa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class NormativaResource extends Resource
{
    protected static ?string $model = Normativa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationLabel = 'Normative Compliance';

    protected static ?string $modelLabel = 'Normativa';

    protected static ?string $pluralModelLabel = 'Normative';

    protected static ?string $recordTitleAttribute = 'control_area';

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR Settings';

    public static function form(Schema $schema): Schema
    {
        return NormativaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NormativaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NormativasTable::configure($table);
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
            'index' => ListNormativas::route('/'),
            'create' => CreateNormativa::route('/create'),
            'view' => ViewNormativa::route('/{record}'),
            'edit' => EditNormativa::route('/{record}/edit'),
        ];
    }
}
