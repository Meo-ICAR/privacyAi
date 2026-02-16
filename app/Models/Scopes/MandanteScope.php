<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class MandanteScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Escludere se l'utente ha il ruolo 'super_admin'
            if ($user->hasRole('super_admin')) {
                return;
            }

            $builder->where($model->getTable() . '.mandante_id', $user->mandante_id);
        }
    }
}
