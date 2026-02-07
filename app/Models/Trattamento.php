<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Trattamento extends Model
{
    use HasUlids, BelongsToMandante;

    protected $fillable = [
        'mandante_id',
        'nome',
        'descrizione',
        'finalita',
        'categorie_interessati',
        'base_giuridica',
        'destinatari',
        'trasferimenti_extra_ue',
        'termini_conservazione',
        'misure_sicurezza',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function categorieDati()
    {
        return $this->belongsToMany(CategoriaDati::class, 'trattamento_categoria_dati');
    }

    public function mandatarie()
    {
        return $this->belongsToMany(Mandatarie::class, 'trattamento_mandataria')
            ->withPivot('ruolo')
            ->withTimestamps();
    }
}
