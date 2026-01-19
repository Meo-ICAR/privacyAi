<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DocumentiTipo extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'documenti_tipo';

    protected $fillable = [
        'nome',
        'slug',
        'categoria',
        'descrizione',
        'is_obbligatorio',
    ];

    protected $casts = [];
}
