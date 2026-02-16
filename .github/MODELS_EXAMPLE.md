# Modelli e Migrazioni di Esempio

Questo documento fornisce i template di codice per implementare rapidamente i modelli principali e le loro relazioni.

---

## 1. Modello Mandante

```php
// app/Models/Mandante.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ActivityLog\Traits\LogsActivity;

class Mandante extends Model implements HasMedia
{
    use HasFactory, HasUlids, InteractsWithMedia, LogsActivity;

    protected $table = 'mandantes';

    protected $fillable = [
        'ragione_sociale',
        'partita_iva',
        'codice_fiscale',
        'email',
        'telefono',
        'indirizzo',
        'cap',
        'citta',
        'provincia',
        'paese',
    ];

    protected function casts(): array
    {
        return [
            'partita_iva' => 'encrypted',
            'codice_fiscale' => 'encrypted',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relations
    public function dipendenti()
    {
        return $this->hasMany(Dipendente::class, 'mandante_id');
    }

    public function software()
    {
        return $this->hasMany(SoftwareFornitore::class, 'mandante_id');
    }

    public function privacyEmails()
    {
        return $this->hasMany(PrivacyEmail::class, 'mandante_id');
    }

    public function mandatarie()
    {
        return $this->belongsToMany(
            Mandataria::class,
            'mandante_mandataries',
            'mandante_id',
            'mandataria_id'
        )
            ->withPivot([
                'data_inizio_servizio',
                'data_fine_servizio',
                'tipo_servizio',
                'note',
                'contratto_path',
                'status_rapporto',
            ])
            ->withTimestamps();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
```

---

## 2. Modello Mandataria

````php
// app/Models/Mandataria.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Mandataria extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'mandataries';

    protected $fillable = [
        'ragione_sociale',
        'partita_iva',
        'email',
        'telefono',
        'settore',
        'descrizione_servizi',
        'contatto_nome',
        'contatto_email',
        'contatto_telefono',
        'url_sito',
        'data_ultimo_contatto',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'partita_iva' => 'encrypted',
            'contatto_telefono' => 'encrypted',
            'data_ultimo_contatto' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relations
    public function mandanti()
    {
        return $this->belongsToMany(
            Mandante::class,
            'mandante_mandataries',
            'mandataria_id',
            'mandante_id'
        )
            ->withPivot([
                'data_inizio_servizio',
                'data_fine_servizio',
                'tipo_servizio',
                'note',
                'contratto_path',
                'status_rapporto',
            ])
            ->withTimestamps();
    }

    public function subfornitori()
    {
        return $this->belongsToMany(
            SubFornitore::class,
            'mandataria_subfornitori',
            'mandataria_id',
            'subfornitore_id'
        )
            ->withPivot([
                'data_inizio_collaborazione',
                'data_fine_collaborazione',
                'numero_risorse',
                'note',
                'contratto_path',
                'status_collaborazione',
            ])
            ->withTimestamps();
    }
}

---

## 3. Modello SubFornitore

```php
// app/Models/SubFornitore.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class SubFornitore extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'subfornitori';

    protected $fillable = [
        'ragione_sociale',
        'partita_iva',
        'email',
        'telefono',
        'tipo',
        'descrizione',
        'indirizzo',
        'citta',
        'paese',
        'url_sito',
        'contatto_nome',
        'contatto_email',
        'contatto_telefono',
        'certificazioni',
        'data_ultimo_audit',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'partita_iva' => 'encrypted',
            'contatto_telefono' => 'encrypted',
            'data_ultimo_audit' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relations
    public function mandatarie()
    {
        return $this->belongsToMany(
            Mandataria::class,
            'mandataria_subfornitori',
            'subfornitore_id',
            'mandataria_id'
        )
            ->withPivot([
                'data_inizio_collaborazione',
                'data_fine_collaborazione',
                'numero_risorse',
                'note',
                'contratto_path',
                'status_collaborazione',
            ])
            ->withTimestamps();
    }

    // Scopes
    public function scopeCallCenter($query)
    {
        return $query->where('tipo', 'call_center');
    }

    public function scopeSoftwareHouse($query)
    {
        return $query->where('tipo', 'software_house');
    }

    public function scopePersonaleEsterno($query)
    {
        return $query->where('tipo', 'personale_esterno');
    }

    public function scopeAttivi($query)
    {
        return $query->where('status', 'attivo');
    }
}
````

---

## 4. Modello Dipendente

```php
// app/Models/Dipendente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\MandanteScope;

class Dipendente extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'dipendentis';

    protected $fillable = [
        'mandante_id',
        'nome',
        'cognome',
        'codice_fiscale',
        'email_personale',
        'numero_documento',
        'tipo_documento',
        'data_nascita',
        'luogo_nascita',
        'qualifica',
        'data_scadenza_formazione_privacy',
        'data_ultimo_corso_privacy',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'codice_fiscale' => 'encrypted',
            'email_personale' => 'encrypted',
            'numero_documento' => 'encrypted',
            'data_nascita' => 'date',
            'data_scadenza_formazione_privacy' => 'date',
            'data_ultimo_corso_privacy' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new MandanteScope());
    }

    // Relations
    public function mandante()
    {
        return $this->belongsTo(Mandante::class, 'mandante_id');
    }

    // Scopes
    public function scopeFormazioneScaduta($query)
    {
        return $query->whereDate('data_scadenza_formazione_privacy', '<=', now()->addDays(30));
    }

    public function scopeAttivi($query)
    {
        return $query->where('status', 'attivo');
    }
}
```

---

## 4. Migrazioni

### 4.1 Migration: Mandante

```php
// database/migrations/0001_01_01_000100_create_mandantes_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandantes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->unique();
            $table->string('partita_iva')->encrypted()->index();
            $table->string('codice_fiscale')->encrypted()->nullable();
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('indirizzo');
            $table->string('cap');
            $table->string('citta');
            $table->string('provincia');
            $table->string('paese')->default('IT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandantes');
    }
};
```

### 4.2 Migration: Mandataria

```php
// database/migrations/0001_01_01_000101_create_mandataries_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandataries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->unique();
            $table->string('partita_iva')->encrypted()->index();
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->enum('settore', ['telefonia', 'energia', 'internet', 'altro']);
            $table->text('descrizione_servizi')->nullable();
            $table->string('contatto_nome')->nullable();
            $table->string('contatto_email')->nullable();
            $table->string('contatto_telefono')->encrypted()->nullable();
            $table->string('url_sito')->nullable();
            $table->date('data_ultimo_contatto')->nullable();
            $table->enum('status', ['attivo', 'inattivo', 'in_valutazione'])->default('in_valutazione');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandataries');
    }
};
```

### 4.3 Migration: Pivot Table

```php
// database/migrations/0001_01_01_000102_create_mandante_mandataries_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandante_mandataries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->foreignUlid('mandataria_id')->constrained('mandataries')->onDelete('cascade');
            $table->date('data_inizio_servizio');
            $table->date('data_fine_servizio')->nullable();
            $table->string('tipo_servizio');
            $table->text('note')->nullable();
            $table->string('contratto_path')->nullable();
            $table->enum('status_rapporto', ['attivo', 'sospeso', 'terminato'])->default('attivo');
            $table->timestamps();

            // Prevent duplicates
            $table->unique(['mandante_id', 'mandataria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandante_mandataries');
    }
};
```

### 4.4 Migration: SubFornitore

```php
// database/migrations/0001_01_01_000104_create_subfornitori_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subfornitori', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->unique();
            $table->string('partita_iva')->encrypted()->index();
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->enum('tipo', ['call_center', 'software_house', 'personale_esterno']);
            $table->text('descrizione')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('citta')->nullable();
            $table->string('paese')->nullable();
            $table->string('url_sito')->nullable();
            $table->string('contatto_nome')->nullable();
            $table->string('contatto_email')->nullable();
            $table->string('contatto_telefono')->encrypted()->nullable();
            $table->text('certificazioni')->nullable();
            $table->date('data_ultimo_audit')->nullable();
            $table->enum('status', ['attivo', 'inattivo', 'in_valutazione'])->default('in_valutazione');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subfornitori');
    }
};
```

### 4.5 Migration: Pivot Table Mandataria-SubFornitore

```php
// database/migrations/0001_01_01_000105_create_mandataria_subfornitori_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandataria_subfornitori', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandataria_id')->constrained('mandataries')->onDelete('cascade');
            $table->foreignUlid('subfornitore_id')->constrained('subfornitori')->onDelete('cascade');
            $table->date('data_inizio_collaborazione');
            $table->date('data_fine_collaborazione')->nullable();
            $table->integer('numero_risorse')->nullable();
            $table->text('note')->nullable();
            $table->string('contratto_path')->nullable();
            $table->enum('status_collaborazione', ['attivo', 'sospeso', 'terminato'])->default('attivo');
            $table->timestamps();

            // Prevent duplicates
            $table->unique(['mandataria_id', 'subfornitore_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandataria_subfornitori');
    }
};
```

### 4.6 Migration: Dipendente

```php
// database/migrations/0001_01_01_000106_create_dipendentis_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dipendentis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->string('nome');
            $table->string('cognome');
            $table->string('codice_fiscale')->encrypted()->index();
            $table->string('email_personale')->encrypted()->nullable();
            $table->string('numero_documento')->encrypted()->nullable();
            $table->enum('tipo_documento', ['carta_identita', 'passaporto', 'patente'])->nullable();
            $table->date('data_nascita');
            $table->string('luogo_nascita');
            $table->string('qualifica');
            $table->date('data_scadenza_formazione_privacy')->nullable();
            $table->date('data_ultimo_corso_privacy')->nullable();
            $table->enum('status', ['attivo', 'inattivo', 'sospeso'])->default('attivo');
            $table->timestamps();

            $table->index('mandante_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dipendentis');
    }
};
```

---

## 5. Utilizzo delle Relazioni

### Query Examples

```php
// Ottenere tutte le mandatarie di una mandante
$mandante = Mandante::find($id);
$mandatarie = $mandante->mandatarie()->get();

// Con pivot data
$mandatarie = $mandante->mandatarie()
    ->where('status_rapporto', 'attivo')
    ->get();

foreach ($mandatarie as $mandataria) {
    echo $mandataria->ragione_sociale; // Nome mandataria
    echo $mandataria->pivot->tipo_servizio; // e.g. 'Telefonia Mobile'
    echo $mandataria->pivot->data_inizio_servizio;
}

// Aggiungere una mandataria
$mandante->mandatarie()->attach($mandatariaId, [
    'data_inizio_servizio' => now()->toDateString(),
    'tipo_servizio' => 'Telefonia Mobile',
    'status_rapporto' => 'attivo',
]);

// Aggiornare il pivot
$mandante->mandatarie()->updateExistingPivot($mandatariaId, [
    'data_fine_servizio' => now()->toDateString(),
    'status_rapporto' => 'terminato',
]);

// Detach
$mandante->mandatarie()->detach($mandatariaId);

// ============================================
// Relazioni Mandataria-SubFornitore
// ============================================

// Ottenere tutti i subfornitori di una mandataria
$mandataria = Mandataria::find($id);
$subfornitori = $mandataria->subfornitori()->get();

// Filtrare per tipo
$callCenters = $mandataria->subfornitori()
    ->where('tipo', 'call_center')
    ->get();

// Filtrare per status collaborazione
$subfornizioniAttive = $mandataria->subfornitori()
    ->where('status_collaborazione', 'attivo')
    ->get();

// Accedere ai dati pivot
foreach ($subfornizioniAttive as $subfornitore) {
    echo $subfornitore->ragione_sociale;
    echo $subfornitore->pivot->numero_risorse; // Es. 15 operatori
    echo $subfornitore->pivot->data_inizio_collaborazione;
    echo $subfornitore->pivot->tipo; // call_center, software_house, etc.
}

// Aggiungere un subfornitore a una mandataria
$mandataria->subfornitori()->attach($subfornitoreId, [
    'data_inizio_collaborazione' => now()->toDateString(),
    'numero_risorse' => 10,
    'tipo' => 'call_center',
    'status_collaborazione' => 'attivo',
]);

// Aggiornare il pivot
$mandataria->subfornitori()->updateExistingPivot($subfornitoreId, [
    'numero_risorse' => 15,
    'data_fine_collaborazione' => now()->toDateString(),
    'status_collaborazione' => 'terminato',
]);

// Detach
$mandataria->subfornitori()->detach($subfornitoreId);
```

---

## 6. Factory Examples

### MandanteFactory

```php
// database/factories/MandanteFactory.php

namespace Database\Factories;

use App\Models\Mandante;
use Illuminate\Database\Eloquent\Factories\Factory;

class MandanteFactory extends Factory
{
    protected $model = Mandante::class;

    public function definition(): array
    {
        return [
            'ragione_sociale' => $this->faker->company(),
            'partita_iva' => $this->faker->numerify('##############'),
            'codice_fiscale' => $this->faker->numerify('##############'),
            'email' => $this->faker->companyEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'indirizzo' => $this->faker->address(),
            'cap' => $this->faker->postcode(),
            'citta' => $this->faker->city(),
            'provincia' => $this->faker->stateAbbr(),
            'paese' => 'IT',
        ];
    }
}
```

### MandatariaFactory

```php
// database/factories/MandatariaFactory.php

namespace Database\Factories;

use App\Models\Mandataria;
use Illuminate\Database\Eloquent\Factories\Factory;

class MandatariaFactory extends Factory
{
    protected $model = Mandataria::class;

    public function definition(): array
    {
        return [
            'ragione_sociale' => $this->faker->company(),
            'partita_iva' => $this->faker->numerify('##############'),
            'email' => $this->faker->companyEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'settore' => $this->faker->randomElement(['telefonia', 'energia', 'internet', 'altro']),
            'descrizione_servizi' => $this->faker->sentence(10),
            'contatto_nome' => $this->faker->name(),
            'contatto_email' => $this->faker->email(),
            'contatto_telefono' => $this->faker->phoneNumber(),
            'url_sito' => $this->faker->url(),
            'data_ultimo_contatto' => $this->faker->dateTime(),
            'status' => 'attivo',
        ];
    }
}
```

### SubFornitoreFactory

```php
// database/factories/SubFornitoreFactory.php

namespace Database\Factories;

use App\Models\SubFornitore;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubFornitoreFactory extends Factory
{
    protected $model = SubFornitore::class;

    public function definition(): array
    {
        return [
            'ragione_sociale' => $this->faker->company(),
            'partita_iva' => $this->faker->numerify('##############'),
            'email' => $this->faker->companyEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'tipo' => $this->faker->randomElement(['call_center', 'software_house', 'personale_esterno']),
            'descrizione' => $this->faker->sentence(15),
            'indirizzo' => $this->faker->address(),
            'citta' => $this->faker->city(),
            'paese' => $this->faker->country(),
            'url_sito' => $this->faker->url(),
            'contatto_nome' => $this->faker->name(),
            'contatto_email' => $this->faker->email(),
            'contatto_telefono' => $this->faker->phoneNumber(),
            'certificazioni' => $this->faker->optional()->sentence(3),
            'data_ultimo_audit' => $this->faker->optional()->dateTime(),
            'status' => 'attivo',
        ];
    }
}
```

### DipendenteFactory

```php
// database/factories/DipendenteFactory.php

namespace Database\Factories;

use App\Models\Dipendente;
use App\Models\Mandante;
use Illuminate\Database\Eloquent\Factories\Factory;

class DipendenteFactory extends Factory
{
    protected $model = Dipendente::class;

    public function definition(): array
    {
        return [
            'mandante_id' => Mandante::factory(),
            'nome' => $this->faker->firstName(),
            'cognome' => $this->faker->lastName(),
            'codice_fiscale' => $this->faker->numerify('##############'),
            'email_personale' => $this->faker->email(),
            'numero_documento' => $this->faker->numerify('##############'),
            'tipo_documento' => $this->faker->randomElement(['carta_identita', 'passaporto', 'patente']),
            'data_nascita' => $this->faker->dateOfBirth(),
            'luogo_nascita' => $this->faker->city(),
            'qualifica' => $this->faker->jobTitle(),
            'data_scadenza_formazione_privacy' => now()->addMonths(6),
            'data_ultimo_corso_privacy' => now()->subMonths(6),
            'status' => 'attivo',
        ];
    }
}
```

---

## 7. Test Examples (Pest PHP)

### Test Relazione Mandante-Mandataria

```php
// tests/Feature/Models/MandanteTest.php

use App\Models\Mandante;
use App\Models\Mandataria;

it('mandante can have many mandatarie', function () {
    $mandante = Mandante::factory()
        ->has(Mandataria::factory()->count(3), 'mandatarie')
        ->create();

    expect($mandante->mandatarie)->toHaveCount(3);
});

it('can attach a mandataria to a mandante', function () {
    $mandante = Mandante::factory()->create();
    $mandataria = Mandataria::factory()->create();

    $mandante->mandatarie()->attach($mandataria->id, [
        'data_inizio_servizio' => now()->toDateString(),
        'tipo_servizio' => 'Telefonia Mobile',
        'status_rapporto' => 'attivo',
    ]);

    expect($mandante->mandatarie)
        ->toHaveCount(1)
        ->first()->id->toBe($mandataria->id);
});

it('prevents duplicate mandante_mandataria relationships', function () {
    $mandante = Mandante::factory()->create();
    $mandataria = Mandataria::factory()->create();

    $mandante->mandatarie()->attach($mandataria->id, [
        'data_inizio_servizio' => now()->toDateString(),
    ]);

    // Should fail on duplicate unique constraint
    expect(fn () => $mandante->mandatarie()->attach($mandataria->id, [
        'data_inizio_servizio' => now()->toDateString(),
    ]))->toThrow();
});
```

### Test Relazione Mandataria-SubFornitore

```php
// tests/Feature/Models/SubFornitoreTest.php

use App\Models\Mandataria;
use App\Models\SubFornitore;

it('mandataria can have many subfornitori', function () {
    $mandataria = Mandataria::factory()
        ->has(SubFornitore::factory()->count(5), 'subfornitori')
        ->create();

    expect($mandataria->subfornitori)->toHaveCount(5);
});

it('can filter subfornitori by type call_center', function () {
    $mandataria = Mandataria::factory()->create();

    $callCenters = SubFornitore::factory()
        ->count(2)
        ->state(['tipo' => 'call_center'])
        ->create();

    $softwareHouses = SubFornitore::factory()
        ->count(2)
        ->state(['tipo' => 'software_house'])
        ->create();

    // Attach both types
    $callCenters->each(fn ($cc) => $mandataria->subfornitori()->attach($cc->id, [
        'data_inizio_collaborazione' => now()->toDateString(),
    ]));

    $softwareHouses->each(fn ($sh) => $mandataria->subfornitori()->attach($sh->id, [
        'data_inizio_collaborazione' => now()->toDateString(),
    ]));

    // Verify only call centers are returned
    $filtered = $mandataria->subfornitori()
        ->where('tipo', 'call_center')
        ->get();

    expect($filtered)->toHaveCount(2);
});

it('can attach subfornitore with pivot data', function () {
    $mandataria = Mandataria::factory()->create();
    $subfornitore = SubFornitore::factory()->create();

    $mandataria->subfornitori()->attach($subfornitore->id, [
        'data_inizio_collaborazione' => '2026-01-19',
        'numero_risorse' => 15,
        'tipo' => 'call_center',
        'status_collaborazione' => 'attivo',
    ]);

    $attached = $mandataria->subfornitori()->first();

    expect($attached->id)->toBe($subfornitore->id)
        ->and($attached->pivot->numero_risorse)->toBe(15)
        ->and($attached->pivot->status_collaborazione)->toBe('attivo');
});

it('prevents duplicate mandataria_subfornitore relationships', function () {
    $mandataria = Mandataria::factory()->create();
    $subfornitore = SubFornitore::factory()->create();

    $mandataria->subfornitori()->attach($subfornitore->id, [
        'data_inizio_collaborazione' => now()->toDateString(),
    ]);

    // Should fail on duplicate unique constraint
    expect(fn () => $mandataria->subfornitori()->attach($subfornitore->id, [
        'data_inizio_collaborazione' => now()->toDateString(),
    ]))->toThrow();
});
```

---

## 10. Modello CorsoTemplate

```php
// app/Models/CorsoTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\MandanteScope;

class CorsoTemplate extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'corso_templates';

    protected $fillable = [
        'mandante_id',
        'titolo',
        'descrizione',
        'validita_mesi',
        'is_obbligatorio',
        'url_risorsa',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_obbligatorio' => 'boolean',
            'validita_mesi' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new MandanteScope());
    }

    // Relations
    public function mandante()
    {
        return $this->belongsTo(Mandante::class, 'mandante_id');
    }

    public function formazioniDipendenti()
    {
        return $this->hasMany(FormazioneDipendente::class, 'corso_template_id');
    }

    // Scopes
    public function scopeObbligatori($query)
    {
        return $query->where('is_obbligatorio', true);
    }

    public function scopeAttivi($query)
    {
        return $query->where('status', 'attivo');
    }
}
```

---

## 11. Modello FormazioneDipendente

```php
// app/Models/FormazioneDipendente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\MandanteScope;
use Carbon\Carbon;

class FormazioneDipendente extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'formazione_dipendentis';

    protected $fillable = [
        'mandante_id',
        'dipendente_id',
        'corso_template_id',
        'data_conseguimento',
        'data_scadenza',
        'certificato_path',
        'note',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_conseguimento' => 'date',
            'data_scadenza' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new MandanteScope());

        // Auto-calcolare data_scadenza quando data_conseguimento o corso_template_id cambia
        static::updating(function ($model) {
            if ($model->isDirty('data_conseguimento') || $model->isDirty('corso_template_id')) {
                $corso = $model->corsoTemplate;
                if ($corso) {
                    $model->data_scadenza = Carbon::parse($model->data_conseguimento)
                        ->addMonths($corso->validita_mesi);
                }
            }
        });

        static::creating(function ($model) {
            // Al momento della creazione, calcolare la data_scadenza
            if ($model->data_conseguimento && $model->corso_template_id) {
                $corso = CorsoTemplate::find($model->corso_template_id);
                $model->data_scadenza = Carbon::parse($model->data_conseguimento)
                    ->addMonths($corso->validita_mesi);
            }
        });
    }

    // Relations
    public function mandante()
    {
        return $this->belongsTo(Mandante::class, 'mandante_id');
    }

    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class, 'dipendente_id');
    }

    public function corsoTemplate()
    {
        return $this->belongsTo(CorsoTemplate::class, 'corso_template_id');
    }

    // Scopes
    public function scopeScadute($query)
    {
        return $query->whereDate('data_scadenza', '<=', now());
    }

    public function scopeProssimeAScadere($query)
    {
        return $query->whereDate('data_scadenza', '>', now())
            ->whereDate('data_scadenza', '<=', now()->addDays(30));
    }

    public function scopeCompletate($query)
    {
        return $query->where('status', 'completato');
    }
}
```

---

## 12. Modello CanaleEmail

```php
// app/Models/CanaleEmail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\MandanteScope;

class CanaleEmail extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'canale_emails';

    protected $fillable = [
        'mandante_id',
        'nome',
        'email',
        'imap_host',
        'imap_port',
        'imap_username',
        'imap_password',
        'encryption_type',
        'last_sync_at',
        'sync_error',
        'parole_chiave_filtro',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'imap_host' => 'encrypted',
            'imap_username' => 'encrypted',
            'imap_password' => 'encrypted',
            'parole_chiave_filtro' => 'array',
            'last_sync_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new MandanteScope());
    }

    // Relations
    public function mandante()
    {
        return $this->belongsTo(Mandante::class, 'mandante_id');
    }

    public function emailSincronizzate()
    {
        return $this->hasMany(EmailSincronizzata::class, 'canale_email_id');
    }

    // Scopes
    public function scopeAttivi($query)
    {
        return $query->where('status', 'attivo');
    }
}
```

---

## 13. Modello EmailSincronizzata

```php
// app/Models/EmailSincronizzata.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\MandanteScope;

class EmailSincronizzata extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'email_sincronizzates';

    protected $fillable = [
        'mandante_id',
        'canale_email_id',
        'email_da',
        'email_a',
        'oggetto',
        'corpo_preview',
        'data_ricezione',
        'contiene_keywords',
        'status_lettura',
    ];

    protected function casts(): array
    {
        return [
            'email_da' => 'encrypted',
            'email_a' => 'encrypted',
            'contiene_keywords' => 'array',
            'data_ricezione' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new MandanteScope());
    }

    // Relations
    public function mandante()
    {
        return $this->belongsTo(Mandante::class, 'mandante_id');
    }

    public function canaleEmail()
    {
        return $this->belongsTo(CanaleEmail::class, 'canale_email_id');
    }

    // Scopes
    public function scopeNonLette($query)
    {
        return $query->where('status_lettura', 'non_letto');
    }

    public function scopeConKeywords($query)
    {
        return $query->whereNotNull('contiene_keywords');
    }
}
```

---

**Ultimo aggiornamento**: 2026-01-19
**Versione**: 1.1

---

## 14. Query Examples per Moduli

### Formazione

```php
// Ottenere i corsi obbligatori di un mandante
$corsiObbligatori = auth()->user()->mandante->corsiTemplate()
    ->where('is_obbligatorio', true)
    ->where('status', 'attivo')
    ->get();

// Assegnare un corso a un dipendente (data_scadenza calcolata auto!)
$dipendente->formazioniDipendenti()->create([
    'mandante_id' => auth()->user()->mandante_id,
    'corso_template_id' => $corsoId,
    'data_conseguimento' => now(),
    // data_scadenza = now() + CorsoTemplate.validita_mesi (booted hook)
]);

// Cercare formazioni scadute
$formazioniScadute = auth()->user()->mandante->formazioniDipendenti()
    ->whereDate('data_scadenza', '<=', now())
    ->get();

// Cercare formazioni in scadenza (entro 30 giorni)
$prossimeAScadere = auth()->user()->mandante->formazioniDipendenti()
    ->whereDate('data_scadenza', '<=', now()->addDays(30))
    ->whereDate('data_scadenza', '>', now())
    ->get();

// Contare dipendenti con formazioni completate
$completate = $mandante->formazioniDipendenti()
    ->where('status', 'completato')
    ->count();
```

### Email & IMAP

```php
// Ottenere tutti i canali email attivi
$canali = auth()->user()->mandante->canaliEmail()
    ->where('status', 'attivo')
    ->get();

// Sincronizzare un canale (webklex/laravel-imap)
$canale = CanaleEmail::find($canaleId);
app(SyncEmailsAction::class)($canale);

// Email non lette con keywords importanti
$emailImportanti = $canale->emailSincronizzate()
    ->where('status_lettura', 'non_letto')
    ->whereNotNull('contiene_keywords')
    ->orderBy('data_ricezione', 'desc')
    ->get();

// Filtrare per keyword specifica (es: "GDPR")
$emailGDPR = $canale->emailSincronizzate()
    ->whereJsonContains('contiene_keywords', 'GDPR')
    ->get();

// Contare email non lette
$nonLette = $canale->emailSincronizzate()
    ->where('status_lettura', 'non_letto')
    ->count();
```

---

## 15. Migrazioni

### 15.1 CorsoTemplate Migration

```php
// database/migrations/0001_01_01_000200_create_corso_templates_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corso_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->string('titolo');
            $table->text('descrizione')->nullable();
            $table->integer('validita_mesi')->comment('Durata validità certificazione in mesi');
            $table->boolean('is_obbligatorio')->default(true);
            $table->string('url_risorsa')->nullable();
            $table->enum('status', ['attivo', 'archiviato'])->default('attivo');
            $table->timestamps();

            $table->index('mandante_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corso_templates');
    }
};
```

### 15.2 FormazioneDipendente Migration

```php
// database/migrations/0001_01_01_000201_create_formazione_dipendentis_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formazione_dipendentis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->foreignUlid('dipendente_id')->constrained('dipendentis')->onDelete('cascade');
            $table->foreignUlid('corso_template_id')->constrained('corso_templates')->onDelete('restrict');
            $table->date('data_conseguimento');
            $table->date('data_scadenza')
                ->comment('Scadenza calcolata dal sistema: data_conseguimento + corso_template.validita_mesi');
            $table->string('certificato_path')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['completato', 'scaduto', 'in_corso'])->default('completato');
            $table->timestamps();

            $table->index(['mandante_id', 'dipendente_id']);
            $table->index('data_scadenza');
            $table->unique(['dipendente_id', 'corso_template_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formazione_dipendentis');
    }
};
```

### 15.3 CanaleEmail Migration

```php
// database/migrations/0001_01_01_000202_create_canale_emails_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canale_emails', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->string('nome');
            $table->string('email');
            $table->string('imap_host')->encrypted();
            $table->integer('imap_port')->default(993);
            $table->string('imap_username')->encrypted();
            $table->string('imap_password')->encrypted()
                ->comment('Password IMAP criptata nel database');
            $table->enum('encryption_type', ['ssl', 'tls', 'none'])->default('ssl');
            $table->timestamp('last_sync_at')
                ->comment('Ultima sincronizzazione IMAP completata con successo')
                ->nullable();
            $table->text('sync_error')
                ->comment('Errore ultima sincronizzazione')
                ->nullable();
            $table->json('parole_chiave_filtro')->nullable()
                ->comment('Array keywords: ["GDPR", "Privacy", "Trattamento dati"]');
            $table->enum('status', ['attivo', 'inattivo', 'errore'])->default('attivo');
            $table->timestamps();

            $table->index('mandante_id');
            $table->unique(['mandante_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canale_emails');
    }
};
```

### 15.4 EmailSincronizzata Migration

```php
// database/migrations/0001_01_01_000203_create_email_sincronizzates_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_sincronizzates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandantes')->onDelete('cascade');
            $table->foreignUlid('canale_email_id')->constrained('canale_emails')->onDelete('cascade');
            $table->string('email_da')->encrypted();
            $table->string('email_a')->encrypted();
            $table->string('oggetto');
            $table->text('corpo_preview')->nullable()
                ->comment('Anteprima corpo (max 500 chars)');
            $table->timestamp('data_ricezione');
            $table->json('contiene_keywords')->nullable()
                ->comment('Array keyword trovate: ["GDPR", "Privacy"]');
            $table->enum('status_lettura', ['non_letto', 'letto', 'archiviato'])->default('non_letto');
            $table->timestamps();

            $table->index(['mandante_id', 'canale_email_id']);
            $table->index('data_ricezione');
            $table->index('status_lettura');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_sincronizzates');
    }
};
```

---

## 16. Factories

### 16.1 CorsoTemplateFactory

```php
// database/factories/CorsoTemplateFactory.php

<?php

namespace Database\Factories;

use App\Models\CorsoTemplate;
use App\Models\Mandante;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorsoTemplateFactory extends Factory
{
    protected $model = CorsoTemplate::class;

    public function definition(): array
    {
        return [
            'mandante_id' => Mandante::factory(),
            'titolo' => $this->faker->words(3, true),
            'descrizione' => $this->faker->sentences(3, true),
            'validita_mesi' => $this->faker->numberBetween(6, 36),
            'is_obbligatorio' => $this->faker->boolean(70),
            'url_risorsa' => $this->faker->url(),
            'status' => 'attivo',
        ];
    }

    public function obbligatorio(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_obbligatorio' => true,
        ]);
    }

    public function archiviato(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archiviato',
        ]);
    }
}
```

### 16.2 FormazioneDipendenteFactory

```php
// database/factories/FormazioneDipendenteFactory.php

<?php

namespace Database\Factories;

use App\Models\CorsoTemplate;
use App\Models\Dipendente;
use App\Models\FormazioneDipendente;
use App\Models\Mandante;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormazioneDipendenteFactory extends Factory
{
    protected $model = FormazioneDipendente::class;

    public function definition(): array
    {
        $mandante = Mandante::factory();
        $dipendente = Dipendente::factory()->create(['mandante_id' => $mandante->id]);
        $corso = CorsoTemplate::factory()->create(['mandante_id' => $mandante->id]);

        $dataConseguimento = $this->faker->dateTimeBetween('-2 years', now());
        $dataScadenza = Carbon::instance($dataConseguimento)
            ->addMonths($corso->validita_mesi);

        return [
            'mandante_id' => $mandante->id,
            'dipendente_id' => $dipendente->id,
            'corso_template_id' => $corso->id,
            'data_conseguimento' => $dataConseguimento,
            'data_scadenza' => $dataScadenza,
            'certificato_path' => $this->faker->url(),
            'note' => $this->faker->sentences(1, true),
            'status' => 'completato',
        ];
    }

    public function scaduta(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'data_scadenza' => now()->subDays(10),
                'status' => 'scaduto',
            ];
        });
    }

    public function prossimeAScadere(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'data_scadenza' => now()->addDays(15),
            ];
        });
    }
}
```

### 16.3 CanaleEmailFactory

```php
// database/factories/CanaleEmailFactory.php

<?php

namespace Database\Factories;

use App\Models\CanaleEmail;
use App\Models\Mandante;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanaleEmailFactory extends Factory
{
    protected $model = CanaleEmail::class;

    public function definition(): array
    {
        return [
            'mandante_id' => Mandante::factory(),
            'nome' => $this->faker->words(2, true),
            'email' => $this->faker->email(),
            'imap_host' => 'imap.gmail.com',
            'imap_port' => 993,
            'imap_username' => $this->faker->email(),
            'imap_password' => $this->faker->password(),
            'encryption_type' => 'ssl',
            'parole_chiave_filtro' => ['GDPR', 'Privacy', 'Trattamento dati'],
            'status' => 'attivo',
        ];
    }

    public function conErrore(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'errore',
            'sync_error' => 'Connection timeout: Unable to reach imap.gmail.com',
        ]);
    }

    public function ultimaSincTempo(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_sync_at' => now()->subMinutes(5),
        ]);
    }
}
```

### 16.4 EmailSincronizzataFactory

```php
// database/factories/EmailSincronizzataFactory.php

<?php

namespace Database\Factories;

use App\Models\CanaleEmail;
use App\Models\EmailSincronizzata;
use App\Models\Mandante;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailSincronizzataFactory extends Factory
{
    protected $model = EmailSincronizzata::class;

    public function definition(): array
    {
        return [
            'mandante_id' => Mandante::factory(),
            'canale_email_id' => CanaleEmail::factory(),
            'email_da' => $this->faker->email(),
            'email_a' => $this->faker->email(),
            'oggetto' => $this->faker->sentence(),
            'corpo_preview' => $this->faker->sentences(2, true),
            'data_ricezione' => $this->faker->dateTimeBetween('-30 days', now()),
            'contiene_keywords' => $this->faker->randomElements(['GDPR', 'Privacy', 'Trattamento', 'Consenso']),
            'status_lettura' => $this->faker->randomElement(['non_letto', 'letto', 'archiviato']),
        ];
    }

    public function nonLetta(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_lettura' => 'non_letto',
        ]);
    }

    public function conKeyword(string $keyword): static
    {
        return $this->state(fn (array $attributes) => [
            'contiene_keywords' => [$keyword],
        ]);
    }
}
```

---

**Ultimo aggiornamento**: 2026-01-19
**Versione**: 1.2
