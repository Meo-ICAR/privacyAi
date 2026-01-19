<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class DipendenteMandatarium extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'dipendente_id',
        'mandataria_id',
        'data_autorizzazione',
        'is_active',
    ];

    protected $casts = [
        'mandataria_id' => 'array',
        'data_autorizzazione' => 'array',
            ];
}