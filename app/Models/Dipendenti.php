<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Dipendenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

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
}