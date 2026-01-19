<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SitiWeb extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'siti_web';

    protected $fillable = [
        'mandante_id',
        'url',
        'nome_progetto',
        'tipo',
        'descrizione_trattamenti',
        'has_cookie_policy',
        'has_privacy_policy',
        'hosting_provider',
    ];

    protected $casts = [];

    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }
}
