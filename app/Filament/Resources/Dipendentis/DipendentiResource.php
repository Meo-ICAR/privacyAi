<?php

namespace App\Filament\Resources\Dipendentis;

use App\Filament\Resources\Dipendentis\Pages\CreateDipendenti;
use App\Filament\Resources\Dipendentis\Pages\EditDipendenti;
use App\Filament\Resources\Dipendentis\Pages\ListDipendentis;
use App\Filament\Resources\Dipendentis\Pages\ViewDipendenti;
use App\Filament\Resources\Dipendentis\Schemas\DipendentiForm;
use App\Filament\Resources\Dipendentis\Schemas\DipendentiInfolist;
use App\Filament\Resources\Dipendentis\Tables\DipendentisTable;
use App\Models\Dipendenti;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DipendentiResource extends Resource
{
    protected static ?string $model = Dipendenti::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';

    public static function form(Schema $schema): Schema
    {
        return DipendentiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DipendentiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DipendentisTable::configure($table);
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
            'index' => ListDipendentis::route('/'),
            'create' => CreateDipendenti::route('/create'),
            'view' => ViewDipendenti::route('/{record}'),
            'edit' => EditDipendenti::route('/{record}/edit'),
        ];
    }
}
