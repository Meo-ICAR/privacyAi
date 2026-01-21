<?php

namespace App\Traits;

use App\Models\Mandante;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToMandante
{
    /**
     * Il "booted" viene eseguito automaticamente da Eloquent.
     * Applica il Global Scope per isolare i dati per ogni Mandante.
     */
    protected static function booted()
    {
        static::addGlobalScope('mandante_isolation', function (Builder $builder) {
            // Se l'utente è loggato e NON è un super_admin, filtra per mandante_id
            if (auth()->check() && ! auth()->user()->hasRole('super_admin')) {
                $builder->where('mandante_id', auth()->user()->mandante_id);
            }
        });

        // Forza l'assegnazione automatica del mandante_id durante la creazione
        static::creating(function ($model) {
            if (auth()->check() && ! auth()->user()->hasRole('super_admin')) {
                $model->mandante_id = auth()->user()->mandante_id;
            }
        });
    }

    /**
     * Relazione con il Mandante (Azienda)
     */
    public function mandante(): BelongsTo
    {
        return $this->belongsTo(Mandante::class);
    }
}
