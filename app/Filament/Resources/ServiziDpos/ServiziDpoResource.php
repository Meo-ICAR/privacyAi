<?php

namespace App\Filament\Resources\ServiziDpos;

use App\Filament\Resources\ServiziDpos\Pages\CreateServiziDpo;
use App\Filament\Resources\ServiziDpos\Pages\EditServiziDpo;
use App\Filament\Resources\ServiziDpos\Pages\ListServiziDpos;
use App\Filament\Resources\ServiziDpos\Pages\ViewServiziDpo;
use App\Filament\Resources\ServiziDpos\Schemas\ServiziDpoForm;
use App\Filament\Resources\ServiziDpos\Schemas\ServiziDpoInfolist;
use App\Filament\Resources\ServiziDpos\Tables\ServiziDposTable;
use App\Models\ServiziDpo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiziDpoResource extends Resource
{
    protected static ?string $model = ServiziDpo::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-euro';

    protected static string|\UnitEnum|null $navigationGroup = 'Configurazione';

    public static function form(Schema $schema): Schema
    {
        return ServiziDpoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiziDpoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiziDposTable::configure($table);
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
            'index' => ListServiziDpos::route('/'),
            'create' => CreateServiziDpo::route('/create'),
            'view' => ViewServiziDpo::route('/{record}'),
            'edit' => EditServiziDpo::route('/{record}/edit'),
        ];
    }
}
