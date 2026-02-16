<?php

namespace App\Filament\Resources\Mandantis\RelationManagers;

use App\Filament\Resources\SitiWebs\Schemas\SitiWebForm;
use App\Filament\Resources\SitiWebs\Tables\SitiWebsTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SitiWebRelationManager extends RelationManager
{
    protected static string $relationship = 'sitiWeb';

    protected static ?string $title = 'Siti Web';

    public function form(Schema $schema): Schema
    {
        return SitiWebForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return SitiWebsTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ])
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
