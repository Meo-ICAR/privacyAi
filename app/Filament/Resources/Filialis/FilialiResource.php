<?php

namespace App\Filament\Resources\Filialis;

use App\Filament\Resources\Filialis\Pages\CreateFiliali;
use App\Filament\Resources\Filialis\Pages\EditFiliali;
use App\Filament\Resources\Filialis\Pages\ListFilialis;
use App\Filament\Resources\Filialis\Pages\ViewFiliali;
use App\Filament\Resources\Filialis\Schemas\FilialiForm;
use App\Filament\Resources\Filialis\Schemas\FilialiInfolist;
use App\Filament\Resources\Filialis\Tables\FilialisTable;
use App\Models\Filiali;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilialiResource extends Resource
{
    protected static ?string $model = Filiali::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return FilialiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FilialiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilialisTable::configure($table);
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
            'index' => ListFilialis::route('/'),
            'create' => CreateFiliali::route('/create'),
            'view' => ViewFiliali::route('/{record}'),
            'edit' => EditFiliali::route('/{record}/edit'),
        ];
    }
}
