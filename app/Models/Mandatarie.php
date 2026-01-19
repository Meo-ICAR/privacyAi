<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mandatarie extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'mandatarie';

    protected $fillable = [
        'mandante_id',
        'ragione_sociale',
        'p_iva',
        'website',
        'landingpage',
        'data_ricezione_nomina',
        'titolare_trattamento',
        'email_referente',
    ];

    protected $casts = [
        'data_ricezione_nomina' => 'array',
    ];

    /**
     * Relazione many-to-one con Mandante
     * Una Mandataria appartiene a un Mandante
     */
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }
}
