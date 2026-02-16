<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MisuraSicurezza extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'misura_sicurezza';

    protected $fillable = [
        'codice',
        'nome',
        'tipo',
        'area',
        'descrizione',
    ];

    protected $casts = [];
}
