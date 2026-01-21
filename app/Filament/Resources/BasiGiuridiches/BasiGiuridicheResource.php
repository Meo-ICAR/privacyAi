<?php

namespace App\Filament\Resources\BasiGiuridiches;

use App\Filament\Resources\BasiGiuridiches\Pages\CreateBasiGiuridiche;
use App\Filament\Resources\BasiGiuridiches\Pages\EditBasiGiuridiche;
use App\Filament\Resources\BasiGiuridiches\Pages\ListBasiGiuridiches;
use App\Filament\Resources\BasiGiuridiches\Pages\ViewBasiGiuridiche;
use App\Filament\Resources\BasiGiuridiches\Schemas\BasiGiuridicheForm;
use App\Filament\Resources\BasiGiuridiches\Schemas\BasiGiuridicheInfolist;
use App\Filament\Resources\BasiGiuridiches\Tables\BasiGiuridichesTable;
use App\Models\BasiGiuridiche;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BasiGiuridicheResource extends Resource
{
    protected static ?string $model = BasiGiuridiche::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scale';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR Settings';

    public static function form(Schema $schema): Schema
    {
        return BasiGiuridicheForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BasiGiuridicheInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BasiGiuridichesTable::configure($table);
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
            'index' => ListBasiGiuridiches::route('/'),
            'create' => CreateBasiGiuridiche::route('/create'),
            'view' => ViewBasiGiuridiche::route('/{record}'),
            'edit' => EditBasiGiuridiche::route('/{record}/edit'),
        ];
    }
}
