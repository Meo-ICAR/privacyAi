<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataBreachResource\Pages\CreateDataBreach;
use App\Filament\Resources\DataBreachResource\Pages\EditDataBreach;
use App\Filament\Resources\DataBreachResource\Pages\ListDataBreaches;
use App\Filament\Resources\DataBreachResource\Pages\ViewDataBreach;
use App\Filament\Resources\DataBreachResource\Schemas\DataBreachForm;
use App\Filament\Resources\DataBreachResource\Schemas\DataBreachInfolist;
use App\Filament\Resources\DataBreachResource\Tables\DataBreachesTable;
use App\Models\DataBreach;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class DataBreachResource extends Resource
{
    protected static ?string $model = DataBreach::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR Settings';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Violazione Dati';

    protected static ?string $pluralModelLabel = 'Violazioni Dati';

    protected static ?string $navigationLabel = 'Violazioni Dati';

    public static function form(Schema $schema): Schema
    {
        return DataBreachForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CorsoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataBreachesTable::configure($table);
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // Add any global scopes to exclude if needed
            ]);
    }
}
