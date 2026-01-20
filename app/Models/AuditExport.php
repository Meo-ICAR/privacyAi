<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditExport extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

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
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandatarie::class);
    }
}
