<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class AuditExport extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'tipo_report',
        'generato_il',
        'mandante_id',
        'user_id',
        'mandataria_id',
    ];

    protected $casts = [
        'mandataria_id' => 'array',
            ];
}