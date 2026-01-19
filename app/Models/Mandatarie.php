<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Mandatarie extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'mandante_id',
        'ragione_sociale',
        'p_iva',
        'website',
        'landingpage',
        'data_ricezione_nomina',
        'titolare_trattamento',
        'email_referente',
    ];

    protected $casts = [
        'data_ricezione_nomina' => 'array',
            ];
}