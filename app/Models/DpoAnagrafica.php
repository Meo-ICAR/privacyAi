<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class DpoAnagrafica extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;
    protected $table = 'dpo_anagrafica';
    protected $fillable = [
        'denominazione',
        'codice_fiscale',
        'partita_iva',
        'email_ordinaria',
        'email_pec',
        'telefono',
        'indirizzo',
        'cap',
        'citta',
        'provincia',
        'numero_iscrizione_albo',
        'certificazioni',
        'is_persona_giuridica',
    ];

    protected $casts = [
            ];
}
