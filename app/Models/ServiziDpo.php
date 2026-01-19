<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ServiziDpo extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'servizi_dpo';

    protected $fillable = [
        'nome',
        'stripe_price_id',
        'prezzo',
        'tipo',
    ];

    protected $casts = [];
}
