<?php

namespace App\Filament\Resources\SitiWebs;

use App\Filament\Resources\SitiWebs\Pages\CreateSitiWeb;
use App\Filament\Resources\SitiWebs\Pages\EditSitiWeb;
use App\Filament\Resources\SitiWebs\Pages\ListSitiWebs;
use App\Filament\Resources\SitiWebs\Pages\ViewSitiWeb;
use App\Filament\Resources\SitiWebs\Schemas\SitiWebForm;
use App\Filament\Resources\SitiWebs\Schemas\SitiWebInfolist;
use App\Filament\Resources\SitiWebs\Tables\SitiWebsTable;
use App\Models\SitiWeb;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SitiWebResource extends Resource
{
    protected static ?string $model = SitiWeb::class;
     protected static bool $shouldRegisterNavigation = false;


    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-americas';

    protected static string|\UnitEnum|null $navigationGroup = 'Compliance';

    public static function form(Schema $schema): Schema
    {
        return SitiWebForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SitiWebInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SitiWebsTable::configure($table);
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
            'index' => ListSitiWebs::route('/'),
            'create' => CreateSitiWeb::route('/create'),
            'view' => ViewSitiWeb::route('/{record}'),
            'edit' => EditSitiWeb::route('/{record}/edit'),
        ];
    }
}
