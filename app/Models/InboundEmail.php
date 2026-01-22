<?php

namespace App\Models;

use App\Models\CanaliEmail;
use App\Models\Mandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;  // Laravel 10+ ULID nativi
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        return $this
            ->belongsTo(CanaliEmail::class, 'canale_email_id')
            ->select(['id', 'username', 'mandante_id']);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check() && $tenantId = auth()->user()->mandante_id) {
                $builder->whereHas('canale', function ($query) use ($tenantId) {
                    $query->where('mandante_id', $tenantId);
                });
            }
        });
    }

    public function mandante()
    {
        return $this->hasOneThrough(
            Mandante::class,
            CanaleEmail::class,
            'id',  // Foreign key on canali_email table
            'id',  // Foreign key on mandanti table
            'canale_email_id',  // Local key on inbound_emails table
            'mandante_id'  // Local key on canali_email table
        );
    }
}
