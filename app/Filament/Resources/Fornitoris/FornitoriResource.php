<?php

namespace App\Filament\Resources\Fornitoris;

use App\Filament\Resources\Fornitoris\Pages\CreateFornitori;
use App\Filament\Resources\Fornitoris\Pages\EditFornitori;
use App\Filament\Resources\Fornitoris\Pages\ListFornitoris;
use App\Filament\Resources\Fornitoris\Pages\ViewFornitori;
use App\Filament\Resources\Fornitoris\Schemas\FornitoriForm;
use App\Filament\Resources\Fornitoris\Schemas\FornitoriInfolist;
use App\Filament\Resources\Fornitoris\Tables\FornitorisTable;
use App\Models\Fornitori;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FornitoriResource extends Resource
{
    protected static ?string $model = Fornitori::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return FornitoriForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FornitoriInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FornitorisTable::configure($table);
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
            'index' => ListFornitoris::route('/'),
            'create' => CreateFornitori::route('/create'),
            'view' => ViewFornitori::route('/{record}'),
            'edit' => EditFornitori::route('/{record}/edit'),
        ];
    }
}
