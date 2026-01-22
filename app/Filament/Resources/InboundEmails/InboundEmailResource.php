<?php

namespace App\Filament\Resources\InboundEmails;

use App\Filament\Resources\InboundEmails\Pages\CreateInboundEmail;
use App\Filament\Resources\InboundEmails\Pages\EditInboundEmail;
use App\Filament\Resources\InboundEmails\Pages\ListInboundEmails;
use App\Filament\Resources\InboundEmails\Pages\ViewInboundEmail;
use App\Filament\Resources\InboundEmails\Schemas\InboundEmailForm;
use App\Filament\Resources\InboundEmails\Schemas\InboundEmailInfolist;
use App\Filament\Resources\InboundEmails\Tables\InboundEmailsTable;
use App\Models\InboundEmail;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;  // Aggiungi questa riga
use BackedEnum;
use UnitEnum;

class InboundEmailResource extends Resource
{
    protected static ?string $model = InboundEmail::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';
    protected static string|\UnitEnum|null $navigationGroup = 'Anagrafiche';
    protected static ?string $modelLabel = 'Messaggio';
    protected static ?string $pluralModelLabel = 'Posta in Arrivo';
    protected static ?int $navigationSort = 1;
    protected static bool $isScopedToTenant = false;

    // Disabilita la creazione manuale: le mail arrivano solo dal comando automatico
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return InboundEmailForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InboundEmailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InboundEmailsTable::configure($table);
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
            'index' => ListInboundEmails::route('/'),
            // 'create' => CreateInboundEmail::route('/create'),
            'view' => ViewInboundEmail::route('/{record}'),
            //  'edit' => EditInboundEmail::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('inbound_emails.*')  // Seleziona esplicitamente le colonne di inbound_emails
            ->whereHas('canale', function ($query) {
                $query
                    ->select(['id', 'username'])  // Seleziona solo le colonne necessarie
                    ->where('mandante_id', auth()->user()->mandante_id)
                    ->orderBy('username', 'asc');
            });
    }
}
