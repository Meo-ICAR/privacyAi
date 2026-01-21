<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CanaliEmail extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, BelongsToMandante;

    protected $table = 'canali_email';

    protected $fillable = [
        'mandante_id',
        'email_provider_id',
        'label',
        'username',
        'password',
        'last_sync_at',
    ];

    protected $casts = [];


    /**
     * Relazione many-to-one con Email provider
     */
    public function emailProvider()
    {
        return $this->belongsTo(EmailProvider::class, 'email_provider_id');
    }
}
