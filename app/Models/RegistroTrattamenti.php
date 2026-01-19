<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class RegistroTrattamenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

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