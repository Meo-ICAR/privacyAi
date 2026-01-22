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

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            // Se l'utente è un super admin e sta impersonando un altro utente
            if (auth()->user()?->hasRole('super_admin') && session()->has('impersonated_by')) {
                // Mostra le holdings del mandante impersonato
                $builder->whereHas('mandante', function ($query) {
                    $query->where('mandante_id', auth()->user()->mandante_id);
                });
            }
            // Altrimenti, applica il normale filtro per mandante
            elseif (auth()->check() && $tenantId = auth()->user()->mandante_id) {
                $builder->whereHas('mandante', function ($query) use ($tenantId) {
                    $query->where('mandante_id', $tenantId);
                });
            }
        });
    }

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
