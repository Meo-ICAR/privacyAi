<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Holding extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'holdings';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'codice_gruppo',
    ];

    protected $casts = [];
}
