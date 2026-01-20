<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditRequest extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'audit_requests';

    protected $fillable = [
        'mandante_id',
        'mandataria_id',
        'titolo',
        'data_inizio',
        'stato',
    ];

    protected $casts = [
        'data_inizio' => 'date',
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante()
    {
        return $this->belongsTo(Mandante::class);
    }

    /**
     * Relazione many-to-one con Mandataria
     */
    public function mandataria()
    {
        return $this->belongsTo(Mandatarie::class);
    }
}
