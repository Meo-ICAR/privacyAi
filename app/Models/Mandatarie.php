<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mandatarie extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

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
        'aziendatipo_id',
    ];

    protected $casts = [
        'data_ricezione_nomina' => 'date',
    ];


    /**
     * Relazione many-to-many con Dipendenti
     */
    public function dipendenti()
    {
        return $this->belongsToMany(Dipendenti::class, 'dipendente_mandataria', 'mandataria_id', 'dipendente_id')
            ->using(DipendenteMandataria::class)
            ->withPivot(['mansione_id', 'data_autorizzazione', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Relazione one-to-many con Audit Requests
     */
    public function auditRequests()
    {
        return $this->hasMany(AuditRequest::class, 'mandataria_id');
    }

    /**
     * Relazione many-to-one con AziendaTipo
     */
    public function aziendaTipo()
    {
        return $this->belongsTo(AziendaTipo::class, 'aziendatipo_id');
    }
}
