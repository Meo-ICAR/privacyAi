<?php

namespace App\Filament\Resources\Mandataries\RelationManagers;

use App\Filament\Resources\AuditRequests\Schemas\AuditRequestForm;
use App\Filament\Resources\AuditRequests\Tables\AuditRequestsTable;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AuditRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'auditRequests';

    protected static ?string $title = 'Richieste Audit';

    public function form(Schema $schema): Schema
    {
        return AuditRequestForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return AuditRequestsTable::configure($table)
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
