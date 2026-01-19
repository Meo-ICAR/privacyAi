<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class FormazioneDipendenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'mandante_id',
        'dipendente_id',
        'corso_template_id',
        'data_conseguimento',
        'data_scadenza',
        'stato',
    ];

    protected $casts = [
        'data_conseguimento' => 'array',
        'data_scadenza' => 'array',
            ];
}