<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Fornitori extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'website',
        'responsabile_trattamento',
        'data_nomina',
        'email_referente',
        'note_compliance',
        'mandante_id',
    ];

    protected $casts = [
        'data_nomina' => 'array',
            ];
}