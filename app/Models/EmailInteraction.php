<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMandante;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmailInteraction extends Model implements HasMedia
{
    use BelongsToMandante, InteractsWithMedia;

    protected $fillable = [
        'message_id',
        'email_address',
        'role',
        'subject',
        'sent_at',
        'domain',
        'label_name'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
