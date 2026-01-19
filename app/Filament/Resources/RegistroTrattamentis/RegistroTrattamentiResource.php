<?php

namespace App\Filament\Resources\RegistroTrattamentis;

use App\Filament\Resources\RegistroTrattamentis\Pages\CreateRegistroTrattamenti;
use App\Filament\Resources\RegistroTrattamentis\Pages\EditRegistroTrattamenti;
use App\Filament\Resources\RegistroTrattamentis\Pages\ListRegistroTrattamentis;
use App\Filament\Resources\RegistroTrattamentis\Pages\ViewRegistroTrattamenti;
use App\Filament\Resources\RegistroTrattamentis\Schemas\RegistroTrattamentiForm;
use App\Filament\Resources\RegistroTrattamentis\Schemas\RegistroTrattamentiInfolist;
use App\Filament\Resources\RegistroTrattamentis\Tables\RegistroTrattamentisTable;
use App\Models\RegistroTrattamenti;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegistroTrattamentiResource extends Resource
{
    protected static ?string $model = RegistroTrattamenti::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RegistroTrattamentiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RegistroTrattamentiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistroTrattamentisTable::configure($table);
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
            'index' => ListRegistroTrattamentis::route('/'),
            'create' => CreateRegistroTrattamenti::route('/create'),
            'view' => ViewRegistroTrattamenti::route('/{record}'),
            'edit' => EditRegistroTrattamenti::route('/{record}/edit'),
        ];
    }
}
