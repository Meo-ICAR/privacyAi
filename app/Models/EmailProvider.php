<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmailProvider extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'email_providers';

    protected $fillable = [
        'pop3_host',
        'pop3_port',
        'pop3_encryption',
    ];

    protected $casts = [];
}
