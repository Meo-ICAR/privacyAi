<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DipendenteMandataria extends Pivot implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'dipendente_mandataria';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dipendente_id',
        'mandataria_id',
        'mansione_id',
        'data_autorizzazione',
        'is_active',
    ];

    protected $casts = [
        'mansione_id' => 'string',
        'data_autorizzazione' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relazione many-to-one con Dipendente
     */
    public function dipendente()
    {
        return $this->belongsTo(Dipendenti::class);
    }

    /**
     * Relazione many-to-one con Mandataria
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandatarie::class);
    }

    /**
     * Relazione many-to-one con Mansione
     */
    public function mansione()
    {
        return $this->belongsTo(Mansioni::class);
    }
}
