<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class AuditRequest extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'mandante_id',
        'mandataria_id',
        'titolo',
        'data_inizio',
        'stato',
    ];

    protected $casts = [
        'mandataria_id' => 'array',
        'data_inizio' => 'array',
            ];
}