<?php

namespace App\Filament\Resources\DpoAnagraficas;

use App\Filament\Resources\DpoAnagraficas\Pages\CreateDpoAnagrafica;
use App\Filament\Resources\DpoAnagraficas\Pages\EditDpoAnagrafica;
use App\Filament\Resources\DpoAnagraficas\Pages\ListDpoAnagraficas;
use App\Filament\Resources\DpoAnagraficas\Pages\ViewDpoAnagrafica;
use App\Filament\Resources\DpoAnagraficas\Schemas\DpoAnagraficaForm;
use App\Filament\Resources\DpoAnagraficas\Schemas\DpoAnagraficaInfolist;
use App\Filament\Resources\DpoAnagraficas\Tables\DpoAnagraficasTable;
use App\Models\DpoAnagrafica;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DpoAnagraficaResource extends Resource
{
    protected static ?string $model = DpoAnagrafica::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static bool $isScopedToTenant = false;


    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return DpoAnagraficaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DpoAnagraficaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DpoAnagraficasTable::configure($table);
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
            'index' => ListDpoAnagraficas::route('/'),
            'create' => CreateDpoAnagrafica::route('/create'),
            'view' => ViewDpoAnagrafica::route('/{record}'),
            'edit' => EditDpoAnagrafica::route('/{record}/edit'),
        ];
    }
}
