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
        'mandataria_id' => 'array',
        'data_autorizzazione' => 'array',
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandatarie::class);
    }
}
