<?php

namespace App\Filament\Resources\CanaliEmails;

use App\Filament\Resources\CanaliEmails\Pages\CreateCanaliEmail;
use App\Filament\Resources\CanaliEmails\Pages\EditCanaliEmail;
use App\Filament\Resources\CanaliEmails\Pages\ListCanaliEmails;
use App\Filament\Resources\CanaliEmails\Pages\ViewCanaliEmail;
use App\Filament\Resources\CanaliEmails\Schemas\CanaliEmailForm;
use App\Filament\Resources\CanaliEmails\Schemas\CanaliEmailInfolist;
use App\Filament\Resources\CanaliEmails\Tables\CanaliEmailsTable;
use App\Models\CanaliEmail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CanaliEmailResource extends Resource
{
    protected static ?string $model = CanaliEmail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static string|\UnitEnum|null $navigationGroup = 'Configurazione';

    public static function form(Schema $schema): Schema
    {
        return CanaliEmailForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CanaliEmailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CanaliEmailsTable::configure($table);
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
            'index' => ListCanaliEmails::route('/'),
            'create' => CreateCanaliEmail::route('/create'),
            'view' => ViewCanaliEmail::route('/{record}'),
            'edit' => EditCanaliEmail::route('/{record}/edit'),
        ];
    }
}
