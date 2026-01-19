<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mansioni extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'mansioni';

    protected $fillable = [
        'nome',
        'descrizione',
        'livello_rischio',
    ];

    protected $casts = [];
}
