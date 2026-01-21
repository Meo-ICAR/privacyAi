<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dipendente extends Model
{
    use SoftDeletes, BelongsToMandante;

    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'codice_fiscale',
        'mandante_id'
    ];

}
