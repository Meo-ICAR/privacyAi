<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids; // Laravel 10+ ULID nativi
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InboundEmail extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function canale()
    {
        return $this->belongsTo(CanaleEmail::class, 'canale_email_id');
    }
}
