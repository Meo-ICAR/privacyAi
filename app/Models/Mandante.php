<?php

namespace App\Models;

use App\Models\Concerns\HasLogo;  // Add this
use App\Models\CanaliEmail;
use App\Models\InboundEmail;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mandante extends Model implements HasMedia, HasName
{
    use HasUlids, InteractsWithMedia, HasLogo;

    public function getFilamentName(): string
    {
        return $this->ragione_sociale;
    }

    /**
     * Register the media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->registerLogoMediaCollection();  // Call the trait method
    }

    protected $table = 'mandanti';

    protected $fillable = [
        'ragione_sociale',
        'p_iva',
        'titolare_trattamento',
        'email_referente',
        'is_active',
        'website',
        'aziendatipo_id',
        'holding_id',
        'stripe_customer_id',
        'stripe_subscription_id',
        'periodicita',
        'stripe_subscription_ends_at',
        'stripe_prezzo_mensile',
        'fatturare_a',
        'indirizzo',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stripe_subscription_ends_at' => 'datetime',
        'periodicita' => 'integer',
    ];

    protected static function booted(): void
    {
        // Aggiungiamo uno Scope Globale anonimo
        static::addGlobalScope('ordine_alfabetico', function (Builder $builder) {
            $builder->orderBy('ragione_sociale', 'asc');
        });
    }

    public function getPeriodicitaTestoAttribute(): string
    {
        return match ($this->periodicita) {
            1 => 'Mensile',
            2 => 'Bimestrale',
            3 => 'Trimestrale',
            6 => 'Semestrale',
            default => 'Non specificato',
        };
    }

    /**
     * Relazione many-to-one con Holding
     */
    public function holding()
    {
        return $this->belongsTo(Holding::class);
    }

    /**
     * Relazione one-to-many con Dipendente
     */
    public function dipendenti(): HasMany
    {
        return $this->hasMany(Dipendente::class);
    }

    /**
     * Relazione one-to-many con Filiali
     */
    public function filiali(): HasMany
    {
        return $this->hasMany(Filiali::class);
    }

    /**
     * Relazione one-to-many con Siti Web
     */
    public function sitiWeb(): HasMany
    {
        return $this->hasMany(SitiWeb::class);
    }

    /**
     * Relazione many-to-one con AziendaTipo
     */
    public function aziendaTipo()
    {
        return $this->belongsTo(AziendaTipo::class, 'aziendatipo_id');
    }

    public function inboundEmails()
    {
        return $this->hasManyThrough(
            InboundEmail::class,
            CanaleEmail::class,
            'mandante_id',  // Foreign key on canali_email table
            'canale_email_id',  // Foreign key on inbound_emails table
            'id',  // Local key on mandanti table
            'id'  // Local key on canali_email table
        );
    }

    public function fornitoreMandatarie()
    {
        return $this->hasMany(FornitoreMandataria::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function primaryUser()
    {
        return $this->hasOne(User::class)->latest();
    }
}
