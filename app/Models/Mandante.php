<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mandante extends Model implements HasMedia, HasName
{
    use HasUlids, InteractsWithMedia;

    public function getFilamentName(): string
    {
        return $this->ragione_sociale;
    }

    protected $table = 'mandanti';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'titolare_trattamento',
        'email_referente',
        'is_active',
        'website',
    ];

    protected $casts = [];

    /**
     * Relazione many-to-one con Mandante
     */
    public function holding()
    {
        return $this->belongsTo(Holding::class);
    }

    /**
     * Relazione one-to-many con Dipendente
     */
    public function dipendenti(): HasMany
    {
        return $this->hasMany(Dipendente::class);
    }
}
