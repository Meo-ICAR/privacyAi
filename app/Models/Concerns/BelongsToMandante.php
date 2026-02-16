<?php

namespace App\Models\Concerns;

use App\Models\Mandante;
use App\Models\Scopes\MandanteScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToMandante
{
    /**
     * Boot the trait.
     */
    protected static function bootBelongsToMandante(): void
    {
        static::addGlobalScope(new MandanteScope());

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();

                // Imposta mandante_id se non è già impostato
                if (empty($model->mandante_id)) {
                    $model->mandante_id = $user->mandante_id;
                }
            }
        });
    }

    /**
     * Get the mandante that owns the model.
     */
    public function mandante(): BelongsTo
    {
        return $this->belongsTo(Mandante::class);
    }
}
