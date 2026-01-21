<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dipendenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'dipendenti';

    protected $fillable = [
        'nome',
        'cognome',
        'codice_fiscale',
        'email_aziendale',
        'mansione_id',
        'data_assunzione',
        'data_dimissioni',
        'is_active',
        'mandante_id',
        'filiale_id',
        'fornitore_id',
    ];

    protected $casts = [
        'data_assunzione' => 'date',
        'data_dimissioni' => 'date',
    ];


    /**
     * Relazione many-to-one con Mandante
     */
    public function filiale()
    {
        return $this->belongsTo(Filiali::class);
    }

    /**
     * Relazione many-to-many con Mandatarie
     */
    public function mandatarie()
    {
        return $this->belongsToMany(Mandatarie::class, 'dipendente_mandataria', 'dipendente_id', 'mandataria_id')
            ->using(DipendenteMandataria::class)
            ->withPivot(['mansione_id', 'data_autorizzazione', 'is_active'])
            ->withTimestamps();
    }

    public function mansione()
    {
        return $this->belongsTo(Mansioni::class);
    }

    public function fornitore()
    {
        return $this->belongsTo(Fornitori::class);
    }

    /**
     * Relazione many-to-many con Corsi
     */
    public function corsi()
    {
        return $this->belongsToMany(Corso::class, 'corso_dipendente', 'dipendente_id', 'corso_id');
    }
}
