<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class AuditFornitori extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'anno_riferimento',
        'data_esecuzione',
        'stato',
        'punteggio_compliance',
        'note_generali',
        'mandante_id',
        'fornitore_id',
        'eseguito_da',
    ];

    protected $casts = [
        'data_esecuzione' => 'array',
            ];
}