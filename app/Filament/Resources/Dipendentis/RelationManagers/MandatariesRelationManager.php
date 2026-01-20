<?php

namespace App\Filament\Resources\Dipendentis\RelationManagers;

use App\Filament\Resources\Mandataries\Tables\MandatariesTable;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class MandatariesRelationManager extends RelationManager
{
    protected static string $relationship = 'mandatarie';

    protected static ?string $title = 'Mandatarie Autorizzate';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('data_autorizzazione')
                    ->required(),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return MandatariesTable::configure($table)
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        DatePicker::make('data_autorizzazione')
                            ->required(),
                        Toggle::make('is_active')
                            ->default(true),
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DetachAction::make(),
            ]);
    }
}
