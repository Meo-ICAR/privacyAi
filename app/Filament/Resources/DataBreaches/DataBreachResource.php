<?php

namespace App\Filament\Resources\DataBreaches;

use App\Filament\Resources\DataBreaches\Pages\CreateDataBreach;
use App\Filament\Resources\DataBreaches\Pages\EditDataBreach;
use App\Filament\Resources\DataBreaches\Pages\ListDataBreaches;
use App\Filament\Resources\DataBreaches\Pages\ViewDataBreach;
use App\Filament\Resources\DataBreaches\Schemas\DataBreachForm;
use App\Filament\Resources\DataBreaches\Schemas\DataBreachInfolist;
use App\Filament\Resources\DataBreaches\Tables\DataBreachesTable;
use App\Models\DataBreach;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataBreachResource extends Resource
{
    protected static ?string $model = DataBreach::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DataBreachForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DataBreachInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataBreachesTable::configure($table);
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
            'index' => ListDataBreaches::route('/'),
            'create' => CreateDataBreach::route('/create'),
            'view' => ViewDataBreach::route('/{record}'),
            'edit' => EditDataBreach::route('/{record}/edit'),
        ];
    }
}
