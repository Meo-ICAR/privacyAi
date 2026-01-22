<?php

namespace App\Filament\Resources\Mandantis;

use App\Filament\Resources\Mandantis\Pages\CreateMandanti;
use App\Filament\Resources\Mandantis\Pages\EditMandanti;
use App\Filament\Resources\Mandantis\Pages\ListMandantis;
use App\Filament\Resources\Mandantis\Pages\ViewMandanti;
use App\Filament\Resources\Mandantis\Schemas\MandantiForm;
use App\Filament\Resources\Mandantis\Schemas\MandantiInfolist;
use App\Filament\Resources\Mandantis\Tables\MandantisTable;
use App\Models\Mandante;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class MandantiResource extends Resource
{
    protected static ?string $model = Mandante::class;


    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return MandantiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MandantiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MandantisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FilialiRelationManager::class,
            RelationManagers\SitiWebRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMandantis::route('/'),
            'create' => CreateMandanti::route('/create'),
            'view' => ViewMandanti::route('/{record}'),
            'edit' => EditMandanti::route('/{record}/edit'),
        ];
    }
}
