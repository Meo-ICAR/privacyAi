<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditExport extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'audit_exports';

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


    /**
     * Relazione many-to-one con Mandante
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandatarie::class);
    }
}
