<?php

namespace App\Filament\Resources\Holdings;

use App\Filament\Resources\Holdings\Pages\CreateHolding;
use App\Filament\Resources\Holdings\Pages\EditHolding;
use App\Filament\Resources\Holdings\Pages\ListHoldings;
use App\Filament\Resources\Holdings\Pages\ViewHolding;
use App\Filament\Resources\Holdings\Schemas\HoldingForm;
use App\Filament\Resources\Holdings\Schemas\HoldingInfolist;
use App\Filament\Resources\Holdings\Tables\HoldingsTable;
use App\Models\Holding;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class HoldingResource extends Resource
{
    protected static ?string $model = Holding::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static string|\UnitEnum|null $navigationGroup = 'Configurazione';

    public static function form(Schema $schema): Schema
    {
        return HoldingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HoldingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HoldingsTable::configure($table);
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
            'index' => ListHoldings::route('/'),
            'create' => CreateHolding::route('/create'),
            'view' => ViewHolding::route('/{record}'),
            'edit' => EditHolding::route('/{record}/edit'),
        ];
    }
}
