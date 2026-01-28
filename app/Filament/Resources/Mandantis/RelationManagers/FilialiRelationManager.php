<?php

namespace App\Filament\Resources\Mandantis\RelationManagers;

use App\Filament\Resources\Filialis\Schemas\FilialiForm;
use App\Filament\Resources\Filialis\Tables\FilialisTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FilialiRelationManager extends RelationManager
{
    protected static string $relationship = 'filiali';

    protected static ?string $title = 'Filiali';

    public function form(Schema $schema): Schema
    {
        return FilialiForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return FilialisTable::configure($table)
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
