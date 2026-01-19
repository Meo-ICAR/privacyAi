<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmailTemplate extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $table = 'email_template';

    protected $fillable = [
        'slug',
        'oggetto',
        'corpo_markdown',
        'placeholders',
    ];

    protected $casts = [];
}
