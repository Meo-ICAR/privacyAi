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
        'holding_id',
        'landingpage',
        'data_ricezione_nomina',
        'titolare_trattamento',
        'email_referente',
        'aziendatipo_id',
        'categorie_dati',
        'descrizione_categorie_dati',
        'categorie_interessati',
        'finalita_trattamento',
        'tipo_trattamento',
        'termini_conservazione',
        'paesi_trasferimento_dati',
        'misure_sicurezza_tecniche',
        'misure_sicurezza_organizzative',
        'responsabili_esterni',
        'base_giuridica',
        'richiesto_consenso',
        'modalita_raccolta_consenso',
        'contitolare_trattamento',
        'note_gdpr',
    ];

    protected $casts = [
        'data_ricezione_nomina' => 'date',
        'richiesto_consenso' => 'boolean',
    ];

    /**
     * Relazione many-to-many con Dipendenti
     */
    public function dipendenti()
    {
        return $this
            ->belongsToMany(Dipendenti::class, 'dipendente_mandataria', 'mandataria_id', 'dipendente_id')
            ->using(DipendenteMandataria::class)
            ->withPivot(['mansione_id', 'data_autorizzazione', 'is_active'])
            ->withTimestamps();
    }

    public function holding()
    {
        return $this->belongsTo(Holding::class);
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

    public function fornitori()
    {
        return $this
            ->belongsToMany(Fornitore::class, 'fornitore_mandataria')
            ->withPivot(['data_invio_accettazione', 'data_accettazione', 'esito', 'annotazioni'])
            ->withTimestamps();
    }
}
