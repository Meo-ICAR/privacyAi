<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Holding extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia, SoftDeletes;

    protected $table = 'holdings';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'codice_gruppo',
    ];

    protected $casts = [];

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile()
            ->useFallbackUrl(asset('images/placeholder-logo.png'))
            ->useFallbackPath(public_path('images/placeholder-logo.png'));
    }

    /**
     * Register the conversions for media files.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->sharpen(10);

        $this
            ->addMediaConversion('preview')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }

    /**
     * Relazione one-to-many con Mandante
     */
    public function mandante(): HasMany
    {
        return $this->hasMany(Mandante::class);
    }

    /**
     * Relazione one-to-many con Fornitore
     */
    public function fornitore(): HasMany
    {
        return $this->hasMany(Fornitore::class);
    }
}
