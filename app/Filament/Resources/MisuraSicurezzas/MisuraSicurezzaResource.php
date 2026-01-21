<?php

namespace App\Filament\Resources\MisuraSicurezzas;

use App\Filament\Resources\MisuraSicurezzas\Pages\CreateMisuraSicurezza;
use App\Filament\Resources\MisuraSicurezzas\Pages\EditMisuraSicurezza;
use App\Filament\Resources\MisuraSicurezzas\Pages\ListMisuraSicurezzas;
use App\Filament\Resources\MisuraSicurezzas\Pages\ViewMisuraSicurezza;
use App\Filament\Resources\MisuraSicurezzas\Schemas\MisuraSicurezzaForm;
use App\Filament\Resources\MisuraSicurezzas\Schemas\MisuraSicurezzaInfolist;
use App\Filament\Resources\MisuraSicurezzas\Tables\MisuraSicurezzasTable;
use App\Models\MisuraSicurezza;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MisuraSicurezzaResource extends Resource
{
    protected static ?string $model = MisuraSicurezza::class;



    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-lock-closed';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR Settings';

    public static function form(Schema $schema): Schema
    {
        return MisuraSicurezzaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MisuraSicurezzaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MisuraSicurezzasTable::configure($table);
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
            'index' => ListMisuraSicurezzas::route('/'),
            'create' => CreateMisuraSicurezza::route('/create'),
            'view' => ViewMisuraSicurezza::route('/{record}'),
            'edit' => EditMisuraSicurezza::route('/{record}/edit'),
        ];
    }
}
