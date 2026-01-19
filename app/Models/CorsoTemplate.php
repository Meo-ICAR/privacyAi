<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CorsoTemplate extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'corsi_template';

    protected $fillable = [
        'titolo',
        'descrizione',
        'validita_mesi',
        'is_obbligatorio',
    ];

    protected $casts = [];
}
