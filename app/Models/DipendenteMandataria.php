<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DipendenteMandataria extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'dipendente_id',
        'mandataria_id',
        'data_autorizzazione',
        'is_active',
    ];

    protected $casts = [
        'data_autorizzazione' => 'array',
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
}
