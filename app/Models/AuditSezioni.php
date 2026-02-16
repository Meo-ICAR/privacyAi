<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditSezioni extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'audit_sezioni';

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

    protected $casts = [];
}
