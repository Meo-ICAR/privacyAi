<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Fornitori extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'fornitori';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'website',
        'responsabile_trattamento',
        'data_nomina',
        'email_referente',
        'note_compliance',
        'mandante_id',
        'aziendatipo_id',
    ];

    protected $casts = [
        'data_nomina' => 'array',
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }

    /**
     * Relazione many-to-one con AziendaTipo
     */
    public function aziendaTipo()
    {
        return $this->belongsTo(AziendaTipo::class, 'aziendatipo_id');
    }
}
