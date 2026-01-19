<?php

namespace App\Filament\Resources\Mansionis;

use App\Filament\Resources\Mansionis\Pages\CreateMansioni;
use App\Filament\Resources\Mansionis\Pages\EditMansioni;
use App\Filament\Resources\Mansionis\Pages\ListMansionis;
use App\Filament\Resources\Mansionis\Pages\ViewMansioni;
use App\Filament\Resources\Mansionis\Schemas\MansioniForm;
use App\Filament\Resources\Mansionis\Schemas\MansioniInfolist;
use App\Filament\Resources\Mansionis\Tables\MansionisTable;
use App\Models\Mansioni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MansioniResource extends Resource
{
    protected static ?string $model = Mansioni::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return MansioniForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MansioniInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MansionisTable::configure($table);
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
            'index' => ListMansionis::route('/'),
            'create' => CreateMansioni::route('/create'),
            'view' => ViewMansioni::route('/{record}'),
            'edit' => EditMansioni::route('/{record}/edit'),
        ];
    }
}
