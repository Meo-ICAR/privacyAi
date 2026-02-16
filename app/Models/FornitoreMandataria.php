<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FornitoreMandataria extends Model
{
    use HasFactory, SoftDeletes, BelongsToMandante;

    protected $table = 'fornitore_mandataria';

    protected $fillable = [
        'fornitore_id',
        'mandataria_id',
        'mandante_id',
        'data_invio_accettazione',
        'data_accettazione',
        'esito',
        'annotazioni',
    ];

    protected $casts = [
        'data_invio_accettazione' => 'date',
        'data_accettazione' => 'date',
        'esito' => 'string',
    ];

    /**
     * Get the fornitore that owns the relationship.
     */
    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class);
    }

    /**
     * Get the mandataria that owns the relationship.
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandataria::class);
    }

    /**
     * Scope a query to filter by fornitore.
     */
    public function scopeWhereFornitore($query, $fornitoreId)
    {
        return $query->where('fornitore_id', $fornitoreId);
    }

    /**
     * Scope a query to filter by mandataria.
     */
    public function scopeWhereMandataria($query, $mandatariaId)
    {
        return $query->where('mandataria_id', $mandatariaId);
    }

    /**
     * Scope a query to filter by mandante.
     */
    public function scopeWhereMandante($query, $mandanteId)
    {
        return $query->where('mandante_id', $mandanteId);
    }

    /**
     * Scope a query to filter by esito.
     */
    public function scopeWhereEsito($query, $esito)
    {
        return $query->where('esito', $esito);
    }
}
