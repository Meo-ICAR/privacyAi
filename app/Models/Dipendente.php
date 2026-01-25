<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dipendente extends Model implements HasMedia
{
    use SoftDeletes, BelongsToMandante, InteractsWithMedia;

    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'codice_fiscale',
        'mandante_id',
        'albo',
        'data_iscrizione',
    ];
}
