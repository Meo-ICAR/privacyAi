<?php

namespace App\Filament\Resources\DipendenteMandataria;

use App\Filament\Resources\DipendenteMandataria\Pages\CreateDipendenteMandataria;
use App\Filament\Resources\DipendenteMandataria\Pages\EditDipendenteMandataria;
use App\Filament\Resources\DipendenteMandataria\Pages\ListDipendenteMandataria;
use App\Filament\Resources\DipendenteMandataria\Pages\ViewDipendenteMandataria;
use App\Filament\Resources\DipendenteMandataria\Schemas\DipendenteMandatariaForm;
use App\Filament\Resources\DipendenteMandataria\Schemas\DipendenteMandatariaInfolist;
use App\Filament\Resources\DipendenteMandataria\Tables\DipendenteMandatariaTable;
use App\Models\DipendenteMandataria;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class DipendenteMandatariaResource extends Resource
{
    protected static ?string $model = DipendenteMandataria::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return DipendenteMandatariaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DipendenteMandatariaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DipendenteMandatariaTable::configure($table);
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
            'index' => ListDipendenteMandataria::route('/'),
            'create' => CreateDipendenteMandataria::route('/create'),
            'view' => ViewDipendenteMandataria::route('/{record}'),
            'edit' => EditDipendenteMandataria::route('/{record}/edit'),
        ];
    }
}
