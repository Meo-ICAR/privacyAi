<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FormazioneDipendenti extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'formazione_dipendenti';

    protected $fillable = [
        'mandante_id',
        'dipendente_id',
        'corso_template_id',
        'data_conseguimento',
        'data_scadenza',
        'stato',
    ];

    protected $casts = [
        'data_conseguimento' => 'date',
        'data_scadenza' => 'date',
    ];


    public function dipendente()
    {
        return $this->belongsTo(Dipendenti::class);
    }

    public function corsoTemplate()
    {
        return $this->belongsTo(CorsoTemplate::class);
    }
}
