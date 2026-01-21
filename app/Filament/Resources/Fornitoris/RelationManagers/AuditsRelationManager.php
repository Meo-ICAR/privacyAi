<?php

namespace App\Filament\Resources\Fornitoris\RelationManagers;

use App\Filament\Resources\AuditFornitoris\Schemas\AuditFornitoriForm;
use App\Filament\Resources\AuditFornitoris\Tables\AuditFornitorisTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AuditsRelationManager extends RelationManager
{
    protected static string $relationship = 'audits';

    protected static ?string $recordTitleAttribute = 'anno_riferimento';

    public function form(Schema $schema): Schema
    {
        return AuditFornitoriForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return AuditFornitorisTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
