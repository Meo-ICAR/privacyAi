<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditFornitori extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'audit_fornitori';

    protected $fillable = [
        'anno_riferimento',
        'data_esecuzione',
        'stato',
        'punteggio_compliance',
        'note_generali',
        'mandante_id',
        'fornitore_id',
        'eseguito_da',
    ];

    protected $casts = [
        'data_esecuzione' => 'date',
    ];


    /**
     * Relazione many-to-one con Mandante
     */
    public function fornitore()
    {
        return $this->belongsTo(Fornitori::class);
    }
}
