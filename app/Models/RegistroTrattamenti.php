<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class RegistroTrattamenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'registro_trattamenti';

    protected $fillable = [
        'versione',
        'payload',
        'data_aggiornamento',
        'mandante_id',
        'user_id',
    ];

    protected $casts = [
        'payload' => 'array',
        'data_aggiornamento' => 'array',
    ];
}
