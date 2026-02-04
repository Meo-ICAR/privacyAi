<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class GmailLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_id',
        'name',
        'dominio',
        'type',
        'mandante_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relazione many-to-one con Mandante
     */
    public function mandante(): BelongsTo
    {
        return $this->belongsTo(Mandante::class);
    }

    /**
     * Scope per trovare le label per dominio
     */
    public function scopeByDomain($query, $domain)
    {
        return $query->where('dominio', $domain);
    }

    /**
     * Scope per trovare le label di un tipo specifico
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope per trovare le label di un mandante specifico
     */
    public function scopeForMandante($query, $mandanteId)
    {
        return $query->where('mandante_id', $mandanteId);
    }

    /**
     * Trova il mandante basandosi sul dominio del website
     */
    public static function findMandanteByDomain($domain)
    {
        // Estrae il dominio base dal website del mandante
        $domain = strtolower(parse_url($domain, PHP_URL_HOST) ?? $domain);

        // Rimuove www. se presente
        $domain = preg_replace('/^www\./', '', $domain);

        return Mandante::where(function ($query) use ($domain) {
            $query
                ->where('website', 'LIKE', "%{$domain}%")
                ->orWhere('website', 'LIKE', "%://{$domain}%")
                ->orWhere('website', 'LIKE', "%www.{$domain}%");
        })->first();
    }

    /**
     * Aggiorna automaticamente il mandante_id basandosi sul dominio
     */
    public function updateMandanteFromDomain()
    {
        if ($this->dominio) {
            $mandante = self::findMandanteByDomain($this->dominio);
            if ($mandante) {
                $this->mandante_id = $mandante->id;
                $this->save();
            }
        }
    }
}
