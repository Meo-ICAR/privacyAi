<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'mandante_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Restituisce i mandanti a cui l'utente ha accesso
     */
    public function getTenants(Panel $panel): Collection
    {
        // Se l'utente è legato a un solo mandante (Relazione 1-a-N)
        return Collection::wrap($this->mandante);

        // Se hai una tabella pivot (Relazione N-a-N)
        // return $this->mandanti;
    }

    /**
     * Verifica se l'utente può accedere a un determinato mandante
     */
    public function canAccessTenant(Model $tenant): bool
    {
        // Logica di autorizzazione: l'utente deve appartenere a quel mandante
        return $this->mandante_id === $tenant->id;
    }

    /**
     * Accesso generico al pannello Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;  // Qui puoi aggiungere controlli sui ruoli (es. Spatie Permissions)
    }
}
