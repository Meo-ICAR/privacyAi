<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class BasiGiuridiche extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        
    ];

    protected $casts = [
            ];
}