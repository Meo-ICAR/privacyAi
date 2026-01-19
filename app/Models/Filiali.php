<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Filiali extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'filiali';

    protected $fillable = [
        'mandante_id',
        'nome',
        'indirizzo',
        'citta',
        'codice_sede',
    ];

    protected $casts = [];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }
}
