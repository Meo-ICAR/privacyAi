<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class CategoriaDati extends Model
{
    use HasUlids;

    protected $table = 'categorie_dati';

    protected $fillable = [
        'nome',
        'descrizione',
        'tipo',
    ];

    public function trattamenti()
    {
        return $this->belongsToMany(Trattamento::class, 'trattamento_categoria_dati');
    }
}
