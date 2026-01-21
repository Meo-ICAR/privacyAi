<?php

namespace App\Filament\Resources\AziendaTipos;

use App\Filament\Resources\AziendaTipos\Pages\ManageAziendaTipos;
use App\Filament\Resources\AziendaTipos\Schemas\AziendaTipoForm;
use App\Filament\Resources\AziendaTipos\Tables\AziendaTiposTable;
use App\Models\AziendaTipo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AziendaTipoResource extends Resource
{
    protected static ?string $model = AziendaTipo::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Tipo Azienda';

    protected static ?string $pluralModelLabel = 'Tipi Azienda';

    public static function form(Schema $schema): Schema
    {
        return AziendaTipoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AziendaTiposTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAziendaTipos::route('/'),
        ];
    }
}
