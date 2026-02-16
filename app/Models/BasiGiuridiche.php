<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BasiGiuridiche extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'basi_giuridiche';

    protected $fillable = [
        'nome',
        'codice',
        'descrizione',
        'riferimento_normativo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
