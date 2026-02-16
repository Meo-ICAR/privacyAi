<?php

namespace App\Filament\Resources\CorsoTemplates;

use App\Filament\Resources\CorsoTemplates\Pages\CreateCorsoTemplate;
use App\Filament\Resources\CorsoTemplates\Pages\EditCorsoTemplate;
use App\Filament\Resources\CorsoTemplates\Pages\ListCorsoTemplates;
use App\Filament\Resources\CorsoTemplates\Pages\ViewCorsoTemplate;
use App\Filament\Resources\CorsoTemplates\Schemas\CorsoTemplateForm;
use App\Filament\Resources\CorsoTemplates\Schemas\CorsoTemplateInfolist;
use App\Filament\Resources\CorsoTemplates\Tables\CorsoTemplatesTable;
use App\Models\CorsoTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CorsoTemplateResource extends Resource
{
    protected static ?string $model = CorsoTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'GDPR Settings';

    public static function form(Schema $schema): Schema
    {
        return CorsoTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CorsoTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorsoTemplatesTable::configure($table);
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
            'index' => ListCorsoTemplates::route('/'),
            'create' => CreateCorsoTemplate::route('/create'),
            'view' => ViewCorsoTemplate::route('/{record}'),
            'edit' => EditCorsoTemplate::route('/{record}/edit'),
        ];
    }
}
