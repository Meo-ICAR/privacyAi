<?php

namespace App\Filament\Resources\Mandantis\Tables;

use App\Filament\Components\LogoColumn;  // Add this
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MandantisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('ragione_sociale', 'asc')
            ->columns([
                // Add this to your table columns:
                LogoColumn::make('logo'),  // Use the reusable component
                TextColumn::make('ragione_sociale')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('p_iva')
                    ->label('P. IVA')
                    ->searchable(),
                TextColumn::make('titolare_trattamento')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('referente')
                    ->label('Referente')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email_referente')
                    ->searchable(),
                TextColumn::make('email_dpo')
                    ->label('Email DPO')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('emailProvider.name')
                    ->label('Email Provider')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gmail_labels_count')
                    ->label('Gmail Labels')
                    ->getStateUsing(fn($record) => $record->gmailLabels()->count())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('holding.ragione_sociale')
                    ->label('Holding')
                    ->sortable(),
                TextColumn::make('stripe_prezzo_mensile')
                    ->label('Prezzo/Mese')
                    ->money('EUR')
                    ->sortable(),
                BadgeColumn::make('periodicita')
                    ->label('Fatturazione')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Mensile',
                        2 => 'Bimestrale',
                        3 => 'Trimestrale',
                        6 => 'Semestrale',
                        default => 'Non specificato'
                    })
                    ->colors([
                        'primary' => fn($state) => in_array($state, [1, 2, 3, 6]),
                        'danger' => 'default',
                    ]),
                TextColumn::make('stripe_subscription_ends_at')
                    ->label('Scadenza')
                    ->date('d/m/Y')
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
                    ->visible(fn() => session()->has('impersonated_by')),
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
                    ->url(function ($record) {
                        // Get the admin user for this mandante
                        $user = $record
                            ->users()
                            ->whereHas('roles', function ($query) {
                                $query->where('name', 'admin');
                            })
                            ->first();

                        if (!$user) {
                            // If no admin user found, try any user
                            $user = $record->users()->first();
                        }

                        if (!$user) {
                            return null;
                        }

                        return route('impersonate', ['user' => $user->id]);
                    })
                    ->visible(function ($record) {
                        return $record->users()->exists();
                    })
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
