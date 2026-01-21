<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Corso extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'corsi';

    protected $fillable = [
        'mandante_id',
        'titolo',
        'data',
        'argomenti',
        'luogo',
        'url',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    /**
     * Relazione many-to-many con Dipendenti
     */
    public function dipendenti(): BelongsToMany
    {
        return $this->belongsToMany(Dipendenti::class, 'corso_dipendente', 'corso_id', 'dipendente_id');
    }
}
