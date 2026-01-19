<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dipendenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'codice_fiscale',
        'email_aziendale',
        'mansione_id',
        'data_assunzione',
        'data_dimissioni',
        'is_active',
        'mandante_id',
        'filiale_id',
        'fornitore_id',
    ];

    protected $casts = [
        'data_assunzione' => 'array',
        'data_dimissioni' => 'array',
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }

    /**
     * Relazione many-to-one con Mandante
     */
    public function filiale()
    {
        return $this->belongsTo(Filiali::class);
    }
}
