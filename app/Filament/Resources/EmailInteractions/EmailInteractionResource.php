<?php

namespace App\Filament\Resources\EmailInteractions;

use App\Filament\Resources\EmailInteractions\Pages\CreateEmailInteraction;
use App\Filament\Resources\EmailInteractions\Pages\EditEmailInteraction;
use App\Filament\Resources\EmailInteractions\Pages\ListEmailInteractions;
use App\Filament\Resources\EmailInteractions\Pages\ViewEmailInteraction;
use App\Filament\Resources\EmailInteractions\Schemas\EmailInteractionForm;
use App\Filament\Resources\EmailInteractions\Schemas\EmailInteractionInfolist;
use App\Filament\Resources\EmailInteractions\Tables\EmailInteractionsTable;
use App\Models\EmailInteraction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmailInteractionResource extends Resource
{
    protected static ?string $model = EmailInteraction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return EmailInteractionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmailInteractionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailInteractionsTable::configure($table);
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
            'index' => ListEmailInteractions::route('/'),
            'create' => CreateEmailInteraction::route('/create'),
            'view' => ViewEmailInteraction::route('/{record}'),
            'edit' => EditEmailInteraction::route('/{record}/edit'),
        ];
    }
}
