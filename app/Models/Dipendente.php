<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dipendente extends Model
{
    use SoftDeletes;

    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'codice_fiscale',
        'mandante_id'
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante(): BelongsTo
    {
        return $this->belongsTo(Mandante::class);
    }
}
