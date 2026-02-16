<?php

namespace App\Filament\Resources\Corsos;

use App\Filament\Resources\Corsos\Pages;
use App\Filament\Resources\Corsos\Schemas\CorsoForm;
use App\Filament\Resources\Corsos\Tables\CorsosTable;
use App\Filament\Resources\Corsos\Schemas\CorsoInfolist;
use App\Models\Corso;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CorsoResource extends Resource
{
    protected static ?string $model = Corso::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'Formazione';

    public static function form(Schema $schema): Schema
    {
        return CorsoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorsosTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CorsoInfolist::configure($schema);
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
            'index' => Pages\ListCorsos::route('/'),
            'create' => Pages\CreateCorso::route('/create'),
            'edit' => Pages\EditCorso::route('/{record}/edit'),
        ];
    }
}
