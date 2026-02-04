<?php

namespace App\Filament\Resources\GmailLabels;

use App\Filament\Resources\GmailLabels\Pages\CreateGmailLabel;
use App\Filament\Resources\GmailLabels\Pages\EditGmailLabel;
use App\Filament\Resources\GmailLabels\Pages\ListGmailLabels;
use App\Filament\Resources\GmailLabels\Pages\ViewGmailLabel;
use App\Filament\Resources\GmailLabels\Schemas\GmailLabelForm;
use App\Filament\Resources\GmailLabels\Schemas\GmailLabelInfolist;
use App\Filament\Resources\GmailLabels\Tables\GmailLabelsTable;
use App\Models\GmailLabel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class GmailLabelResource extends Resource
{
    protected static ?string $model = GmailLabel::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Email';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Gmail Label';
    protected static ?string $pluralModelLabel = 'Gmail Labels';

    public static function form(Schema $schema): Schema
    {
        return GmailLabelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GmailLabelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GmailLabelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGmailLabels::route('/'),
            'create' => CreateGmailLabel::route('/create'),
            'view' => ViewGmailLabel::route('/{record}'),
            'edit' => EditGmailLabel::route('/{record}/edit'),
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
