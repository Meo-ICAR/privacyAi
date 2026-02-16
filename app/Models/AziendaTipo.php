<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AziendaTipo extends Model
{
    use HasUlids;

    protected $table = 'aziendatipo';

    protected $fillable = [
        'name',
    ];

    public function mandanti(): HasMany
    {
        return $this->hasMany(Mandante::class, 'aziendatipo_id');
    }

    public function mandatarie(): HasMany
    {
        return $this->hasMany(Mandatarie::class, 'aziendatipo_id');
    }

    public function fornitori(): HasMany
    {
        return $this->hasMany(Fornitori::class, 'aziendatipo_id');
    }
}
