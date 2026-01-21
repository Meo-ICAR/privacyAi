<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CorsoDipendente extends Pivot implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'corso_dipendente';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'corso_id',
        'dipendente_id',
    ];
}
