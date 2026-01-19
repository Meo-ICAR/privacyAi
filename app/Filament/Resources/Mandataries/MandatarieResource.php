<?php

namespace App\Filament\Resources\Mandataries;

use App\Filament\Resources\Mandataries\Pages\CreateMandatarie;
use App\Filament\Resources\Mandataries\Pages\EditMandatarie;
use App\Filament\Resources\Mandataries\Pages\ListMandataries;
use App\Filament\Resources\Mandataries\Pages\ViewMandatarie;
use App\Filament\Resources\Mandataries\Schemas\MandatarieForm;
use App\Filament\Resources\Mandataries\Schemas\MandatarieInfolist;
use App\Filament\Resources\Mandataries\Tables\MandatariesTable;
use App\Models\Mandatarie;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MandatarieResource extends Resource
{
    protected static ?string $model = Mandatarie::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MandatarieForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MandatarieInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MandatariesTable::configure($table);
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
            'index' => ListMandataries::route('/'),
            'create' => CreateMandatarie::route('/create'),
            'view' => ViewMandatarie::route('/{record}'),
            'edit' => EditMandatarie::route('/{record}/edit'),
        ];
    }
}
