<?php

namespace App\Filament\Resources\Trattamentos;

use App\Filament\Resources\Trattamentos\Pages\CreateTrattamento;
use App\Filament\Resources\Trattamentos\Pages\EditTrattamento;
use App\Filament\Resources\Trattamentos\Pages\ListTrattamentos;
use App\Filament\Resources\Trattamentos\Pages\ViewTrattamento;
use App\Filament\Resources\Trattamentos\Schemas\TrattamentoForm;
use App\Filament\Resources\Trattamentos\Schemas\TrattamentoInfolist;
use App\Filament\Resources\Trattamentos\Tables\TrattamentosTable;
use App\Models\Trattamento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrattamentoResource extends Resource
{
    protected static ?string $model = Trattamento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TrattamentoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrattamentoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrattamentosTable::configure($table);
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
            'index' => ListTrattamentos::route('/'),
            'create' => CreateTrattamento::route('/create'),
            'view' => ViewTrattamento::route('/{record}'),
            'edit' => EditTrattamento::route('/{record}/edit'),
        ];
    }
}
