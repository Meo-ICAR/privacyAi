<?php

namespace App\Filament\Resources\DipendenteMandataria;

use App\Filament\Resources\DipendenteMandataria\Pages\CreateDipendenteMandatarium;
use App\Filament\Resources\DipendenteMandataria\Pages\EditDipendenteMandatarium;
use App\Filament\Resources\DipendenteMandataria\Pages\ListDipendenteMandataria;
use App\Filament\Resources\DipendenteMandataria\Pages\ViewDipendenteMandatarium;
use App\Filament\Resources\DipendenteMandataria\Schemas\DipendenteMandatariumForm;
use App\Filament\Resources\DipendenteMandataria\Schemas\DipendenteMandatariumInfolist;
use App\Filament\Resources\DipendenteMandataria\Tables\DipendenteMandatariaTable;
use App\Models\DipendenteMandatarium;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DipendenteMandatariumResource extends Resource
{
    protected static ?string $model = DipendenteMandatarium::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DipendenteMandatariumForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DipendenteMandatariumInfolist::configure($schema);
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
            'create' => CreateDipendenteMandatarium::route('/create'),
            'view' => ViewDipendenteMandatarium::route('/{record}'),
            'edit' => EditDipendenteMandatarium::route('/{record}/edit'),
        ];
    }
}
