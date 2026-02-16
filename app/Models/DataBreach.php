<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class DataBreach extends Model
{
    use HasUlids, BelongsToMandante;

    protected $fillable = [
        'mandante_id',
        'description',
        'occurred_at',
        'detected_at',
        'is_notified_authority',
        'authority_notified_at',
        'is_notified_subjects',
        'subjects_notified_at',
        'risk_level',
        'status',
        'notes',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'detected_at' => 'datetime',
        'authority_notified_at' => 'datetime',
        'subjects_notified_at' => 'datetime',
        'is_notified_authority' => 'boolean',
        'is_notified_subjects' => 'boolean',
    ];
}
