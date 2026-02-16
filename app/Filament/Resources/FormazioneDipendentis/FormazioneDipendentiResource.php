<?php

namespace App\Filament\Resources\FormazioneDipendentis;

use App\Filament\Resources\FormazioneDipendentis\Pages\CreateFormazioneDipendenti;
use App\Filament\Resources\FormazioneDipendentis\Pages\EditFormazioneDipendenti;
use App\Filament\Resources\FormazioneDipendentis\Pages\ListFormazioneDipendentis;
use App\Filament\Resources\FormazioneDipendentis\Pages\ViewFormazioneDipendenti;
use App\Filament\Resources\FormazioneDipendentis\Schemas\FormazioneDipendentiForm;
use App\Filament\Resources\FormazioneDipendentis\Schemas\FormazioneDipendentiInfolist;
use App\Filament\Resources\FormazioneDipendentis\Tables\FormazioneDipendentisTable;
use App\Models\FormazioneDipendenti;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormazioneDipendentiResource extends Resource
{
    protected static ?string $model = FormazioneDipendenti::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'Formazione';

    public static function form(Schema $schema): Schema
    {
        return FormazioneDipendentiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FormazioneDipendentiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormazioneDipendentisTable::configure($table);
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
            'index' => ListFormazioneDipendentis::route('/'),
            'create' => CreateFormazioneDipendenti::route('/create'),
            'view' => ViewFormazioneDipendenti::route('/{record}'),
            'edit' => EditFormazioneDipendenti::route('/{record}/edit'),
        ];
    }
}
