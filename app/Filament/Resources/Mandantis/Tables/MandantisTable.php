<?php

namespace App\Filament\Resources\Mandantis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\Action;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MandantisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ragione_sociale')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('p_iva')
                    ->label('P. IVA')
                    ->searchable(),
                TextColumn::make('titolare_trattamento')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_referente')
                    ->searchable(),
                TextColumn::make('holding.ragione_sociale')
                    ->label('Holding')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->headerActions([
                Action::make('stopImpersonating')
                    ->label('Dismiss Impersonation')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->url(route('stop-impersonating'))
                    ->visible(fn () => session()->has('impersonated_by')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('impersonate')
                    ->label('Impersonate')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->url(fn ($record) => route('impersonate', [
                        'user' => User::where('mandante_id', $record->id)
                            ->role('admin')
                            ->first()?->id ?? User::where('mandante_id', $record->id)->first()?->id
                    ]))
                    ->visible(fn () => Auth::user()->hasRole('super_admin') && ! session()->has('impersonated_by'))
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
