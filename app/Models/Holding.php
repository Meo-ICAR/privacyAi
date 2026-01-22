<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
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
        'categorie_dati',
        'descrizione_categorie_dati',
        'categorie_interessati',
        'finalita_trattamento',
        'tipo_trattamento',
        'termini_conservazione',
        'paesi_trasferimento_dati',
        'misure_sicurezza_tecniche',
        'misure_sicurezza_organizzative',
        'responsabili_esterni',
        'base_giuridica',
        'richiesto_consenso',
        'modalita_raccolta_consenso',
        'contitolare_trattamento',
        'note_gdpr',
    ];

    protected $casts = [
        // ... existing casts
        'richiesto_consenso' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            // If the user is a super admin and is impersonating another user
            if (auth()->user()?->hasRole('super_admin') && session()->has('impersonated_by')) {
                // Show holdings of the impersonated tenant
                $builder->whereHas('mandante', function ($query) {
                    $query->where('mandante_id', auth()->user()->mandante_id);
                });
            }
            // Otherwise, apply the normal tenant filter
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

    public function mandatarie()
    {
        return $this->hasMany(Mandatarie::class);
    }

    /**
     * Relazione one-to-many con Fornitore
     */
    public function fornitore(): HasMany
    {
        return $this->hasMany(Fornitore::class);
    }
}
