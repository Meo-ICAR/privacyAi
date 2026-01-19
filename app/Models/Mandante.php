<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Filament\Models\Contracts\HasName;

class Mandante extends Model implements HasMedia, HasName
{
    use HasUlids, InteractsWithMedia;

    public function getFilamentName(): string
    {
        return $this->ragione_sociale;
    }

    protected $table = 'mandanti';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'titolare_trattamento',
        'email_referente',
        'is_active',
        'website',
    ];

    protected $casts = [];
}
