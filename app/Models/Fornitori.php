<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Fornitori extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'fornitori';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'website',
        'responsabile_trattamento',
        'fornitura_prodotti',
        'data_nomina',
        'email_referente',
        'note_compliance',
        'mandante_id',
        'aziendatipo_id',
        'mansione_id',
        'holding_id',
        'albo',
        'data_iscrizione',
    ];

    protected $casts = [
        'data_nomina' => 'date',
    ];

    /**
     * Relazione many-to-one con Mansione
     */
    public function mansione()
    {
        return $this->belongsTo(Mansioni::class);
    }

    /**
     * Relazione many-to-one con AziendaTipo
     */
    public function aziendaTipo()
    {
        return $this->belongsTo(AziendaTipo::class, 'aziendatipo_id');
    }

    /**
     * Relazione one-to-many con AuditFornitori
     */
    public function audits()
    {
        return $this->hasMany(AuditFornitori::class, 'fornitore_id');
    }

    public function mandatarie()
    {
        return $this
            ->belongsToMany(Mandatarie::class, 'fornitore_mandataria')
            ->withPivot(['data_invio_accettazione', 'data_accettazione', 'esito', 'annotazioni'])
            ->withTimestamps();
    }
}
