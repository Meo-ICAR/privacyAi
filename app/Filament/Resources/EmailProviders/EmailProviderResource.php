<?php

namespace App\Filament\Resources\EmailProviders;

use App\Filament\Resources\EmailProviders\Pages\CreateEmailProvider;
use App\Filament\Resources\EmailProviders\Pages\EditEmailProvider;
use App\Filament\Resources\EmailProviders\Pages\ListEmailProviders;
use App\Filament\Resources\EmailProviders\Pages\ViewEmailProvider;
use App\Filament\Resources\EmailProviders\Schemas\EmailProviderForm;
use App\Filament\Resources\EmailProviders\Schemas\EmailProviderInfolist;
use App\Filament\Resources\EmailProviders\Tables\EmailProvidersTable;
use App\Models\EmailProvider;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

class EmailProviderResource extends Resource
{
    protected static ?string $model = EmailProvider::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-server';

    protected static bool $isScopedToTenant = false;

    protected static string|\UnitEnum|null $navigationGroup = 'Configurazione';

    public static function form(Schema $schema): Schema
    {
        return EmailProviderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmailProviderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailProvidersTable::configure($table);
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
            'index' => ListEmailProviders::route('/'),
            'create' => CreateEmailProvider::route('/create'),
            'view' => ViewEmailProvider::route('/{record}'),
            'edit' => EditEmailProvider::route('/{record}/edit'),
        ];
    }
}
