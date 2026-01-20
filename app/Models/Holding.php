<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Holding extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, SoftDeletes;

    protected $table = 'holdings';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'codice_gruppo',
    ];

    protected $casts = [];

    /**
     * Relazione one-to-many con Dipendente
     */
    public function mandante(): HasMany
    {
        return $this->hasMany(Mandante::class);
    }
}
