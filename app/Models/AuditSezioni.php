<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class AuditSezioni extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'nome',
        'descrizione',
        'ordine',
        'sezione_id',
        'testo_domanda',
        'riferimento_normativo',
        'peso',
        'is_critica',
    ];

    protected $casts = [
            ];
}