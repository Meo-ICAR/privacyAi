# Project Blueprint: Privacy Management System (PMS)

**Stack**: Laravel 12 | Filament v3 | PHP 8.4 | MySQL 8.0

---

## 1. Architettura e Standard

### Primary Keys

- **Esclusivamente ULID** tramite trait `HasUlids` su tutti i modelli
- Non usare auto-increment IDs
- Ensures: distribuzione dei dati, privacy, evita enumeration attacks

### Localization

- **Lingua predefinita**: `it` (Italiano)
- **Timezone**: `Europe/Rome`
- Configurato in `config/app.php` e `AppServiceProvider`
- Tradurre tutti gli output utente in `lang/it/` e `lang/en/`

### Design Pattern: Action Classes

- Logica di business complessa deve vivere in `app/Actions/`
- Esempio: `GenerateRegistroTrattamentiAction`, `SyncPrivacyEmailsAction`
- Mantengono controller snelli; facili da testare e riusare

```php
namespace App\Actions;

class GenerateRegistroTrattamentiAction
{
    public function __invoke(Mandante $mandante)
    {
        // logica PDF export
    }
}
```

### Encryption: PII (Personally Identifiable Information)

Criptare sempre i seguenti campi sui modelli:

- `codice_fiscale` (CF)
- `partita_iva` (P.IVA)
- `email_personale` (email private)
- `numero_documento` (ID documents)
- `numero_conto` (Bank account numbers)

**Implementazione**:

```php
protected function casts(): array {
    return [
        'codice_fiscale' => 'encrypted',
        'email_personale' => 'encrypted',
    ];
}
```

Usar sempre `Illuminate\Database\Eloquent\Casts\Encrypted` per i campi sensibili.

---

## 2. Multi-Tenancy (Isolamento Dati)

### Tenant Model: Mandante

La Mandante rappresenta la Società/Organizzazione. È la radice dell'isolamento.

### Global Scope Requirement

Ogni modello tenant-scoped **deve** applicare un filtro automatico:

```php
protected static function booted()
{
    static::addGlobalScope(new MandanteScope());
}
```

**MandanteScope** deve:

1. Filtrare per `where('mandante_id', auth()->user()->mandante_id())`
2. **Escludere** se `auth()->user()->hasRole('super_admin')`
3. Lanciare eccezione se `auth()->check() === false`

**Modelli tenant-scoped**:

- Dipendente
- SoftwareFornitore
- PrivacyEmail
- Audit (attività PII)
- Documento, Attestato, FormularioConsensualità
- Qualsiasi future risorsa aggiunta

---

## 3. Moduli Principali (Database Schema)

### 3.1 Mandante (Companies)

```
Table: mandantes
├── id (ULID)
├── ragione_sociale (string, unique within scope)
├── partita_iva (string, encrypted)
├── codice_fiscale (string, encrypted, nullable)
├── email (string)
├── telefono (string, nullable)
├── logo_path (string, nullable) → Media Library
├── indirizzo (text)
├── cap (string)
├── citta (string)
├── provincia (string)
├── paese (string, default: 'IT')
├── created_at, updated_at
```

**Relations**:

- `hasMany('Dipendente')`
- `hasMany('SoftwareFornitore')`
- `hasMany('PrivacyEmail')`
- `hasMany('AuditLog')`
- `belongsToMany('Mandataria')` → Via pivot table `mandante_mandataries`

---

### 3.2 Mandataria (Service Providers / Telco Companies)

```
Table: mandataries
├── id (ULID)
├── ragione_sociale (string, unique)
├── partita_iva (string, encrypted)
├── email (string)
├── telefono (string, nullable)
├── settore (enum: 'telefonia', 'energia', 'internet', 'altro')
├── descrizione_servizi (text, nullable) → e.g. 'Fornitura servizi telefonici, hosting cloud'
├── contatto_nome (string, nullable)
├── contatto_email (string, nullable)
├── contatto_telefono (string, encrypted, nullable)
├── url_sito (string, nullable)
├── data_ultimo_contatto (date, nullable)
├── status (enum: 'attivo', 'inattivo', 'in_valutazione')
├── created_at, updated_at
```

**Relations**:

- `belongsToMany('Mandante')` → Pivot: `mandante_mandataries`
- `belongsToMany('SubFornitore')` → Pivot: `mandataria_subfornitori`

**Pivot Table**: `mandante_mandataries`

```
Table: mandante_mandataries
├── id (ULID)
├── mandante_id (ULID, foreign)
├── mandataria_id (ULID, foreign)
├── data_inizio_servizio (date)
├── data_fine_servizio (date, nullable)
├── tipo_servizio (string) → e.g. 'Telefonia Mobile', 'Hosting', 'Email'
├── note (text, nullable)
├── contratto_path (string, nullable) → Media Library reference
├── status_rapporto (enum: 'attivo', 'sospeso', 'terminato')
├── created_at, updated_at
```

**Unique Index**: `(mandante_id, mandataria_id)` per evitare duplicati

---

### 3.2bis SubFornitore (Third-Party Vendors)

```
Table: subfornitori
├── id (ULID)
├── ragione_sociale (string, unique)
├── partita_iva (string, encrypted)
├── email (string)
├── telefono (string, nullable)
├── tipo (enum: 'call_center', 'software_house', 'personale_esterno')
├── descrizione (text, nullable) → e.g. 'Call center specializzato in customer support'
├── indirizzo (string, nullable)
├── citta (string, nullable)
├── paese (string, nullable)
├── url_sito (string, nullable)
├── contatto_nome (string, nullable)
├── contatto_email (string, nullable)
├── contatto_telefono (string, encrypted, nullable)
├── certificazioni (text, nullable) → e.g. 'ISO 27001, SOC2'
├── data_ultimo_audit (date, nullable)
├── status (enum: 'attivo', 'inattivo', 'in_valutazione')
├── created_at, updated_at
```

**Relations**:

- `belongsToMany('Mandataria')` → Pivot: `mandataria_subfornitori`

**Pivot Table**: `mandataria_subfornitori`

```
Table: mandataria_subfornitori
├── id (ULID)
├── mandataria_id (ULID, foreign)
├── subfornitore_id (ULID, foreign)
├── data_inizio_collaborazione (date)
├── data_fine_collaborazione (date, nullable)
├── numero_risorse (int, nullable) → e.g. numero di operatori, developer
├── note (text, nullable)
├── contratto_path (string, nullable) → Media Library reference
├── status_collaborazione (enum: 'attivo', 'sospeso', 'terminato')
├── created_at, updated_at
```

**Unique Index**: `(mandataria_id, subfornitore_id)` per evitare duplicati

---

### 3.2ter Mansione (Job Roles / Positions)

```
Table: mansioni
├── id (ULID)
├── mandante_id (ULID, foreign, nullable) → NULL = template globale, NOT NULL = specifico per mandante
├── nome (string) → e.g. 'Responsabile Privacy', 'Data Protection Officer', 'Operatore Call Center'
├── descrizione (text, nullable)
├── livello_rischio (enum: 'basso', 'medio', 'alto', 'critico') → Automatizza i controlli di compliance
├── richiede_formazione_privacy (boolean, default: true)
├── giorni_scadenza_formazione (int, nullable) → e.g. 365 giorni prima della scadenza
├── certificazioni_richieste (json, nullable) → Array: ['GDPR', 'ISO 27001', ...]
├── responsabile_revisione (boolean, default: false) → Ruolo strategico
├── status (enum: 'attivo', 'archiviato')
├── created_at, updated_at
```

**Purpose**: Centralizza la definizione dei ruoli per Dipendenti e Fornitori. Include un attributo `livello_rischio` per automatizzare i controlli di compliance secondo le best practices GDPR.

**Relations**:

- `hasMany('Dipendente')` → Un dipendente ha una mansione
- `hasMany('Fornitore')` (per SubFornitore) → Possibilità di associare ruoli anche ai fornitori

**Compliance Logic**:

- **Basso**: No special controls needed
- **Medio**: Requires annual privacy training + audit review
- **Alto**: Requires annual privacy training + quarterly audit review + DPA monitoring
- **Critico**: Requires certification, 24/7 activity log, monthly compliance reports

---

### 3.3 Dipendente (Employees)

```
Table: dipendentis
├── id (ULID)
├── mandante_id (ULID, foreign)
├── mansione_id (ULID, foreign, nullable) → Link to job role with compliance automation
├── nome (string)
├── cognome (string)
├── codice_fiscale (string, encrypted)
├── email_personale (string, encrypted, nullable)
├── numero_documento (string, encrypted, nullable)
├── tipo_documento (enum: 'carta_identita', 'passaporto', 'patente')
├── data_nascita (date)
├── luogo_nascita (string)
├── qualifica (string) → e.g. 'Responsabile Privacy', 'Operatore'
├── data_scadenza_formazione_privacy (date, nullable)
├── data_ultimo_corso_privacy (date, nullable)
├── status (enum: 'attivo', 'inattivo', 'sospeso')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `belongsTo('Mansione')` → Link to job role with compliance requirements
- `hasMany('AuditLog')`

**Scopes**:

- `formazione_scaduta()` → Dipendenti con scadenza entro 30 giorni
- `attivi()` → Solo status 'attivo'

---

### 3.4 SoftwareFornitore (Software Vendors)

```
Table: software_fornitori
├── id (ULID)
├── mandante_id (ULID, foreign)
├── nome (string)
├── produttore (string)
├── versione (string, nullable)
├── locazione_dati (enum: 'UE', 'USA', 'EXTRA_UE')
├── descrizione (text, nullable)
├── note_privacy (text, nullable) → Info su GDPR compliance
├── url_privacy_policy (string, nullable)
├── data_ultimo_audit (date, nullable)
├── certificato_iso27001 (boolean, default: false)
├── status (enum: 'attivo', 'inattivo', 'in_valutazione')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `hasMany('Documento')` → Contratti DPA, Privacy Policy

**Validation Rules**:

- `locazione_dati` deve essere in ['UE', 'USA', 'EXTRA_UE']
- Se `locazione_dati === 'EXTRA_UE'`, obbligare `note_privacy`

---

### 3.5 PrivacyEmail (IMAP Sync)

```
Table: privacy_emails
├── id (ULID)
├── mandante_id (ULID, foreign)
├── email_address (string, encrypted)
├── imap_host (string, encrypted)
├── imap_port (int, default: 993)
├── imap_username (string, encrypted)
├── imap_password (string, encrypted)
├── sync_enabled (boolean, default: true)
├── last_sync_at (timestamp, nullable)
├── sync_error (text, nullable)
├── folder_mapping (json) → {'Inbox': 'INBOX', 'Richieste': 'Requests'}
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `hasMany('SyncLog')`

**Job**: `SyncPrivacyEmailsJob::dispatch()` (async, once daily)

- Sincronizza emails da IMAP
- Estrae DPIA/Consent forms
- Loga accessi

---

### 3.6 Audit Log (Activity Tracking)

Usa **spatie/laravel-activitylog** per tracciare accessi a dati PII.

```
Table: activity_log (auto-managed by Spatie)
├── id
├── log_name (string, default: 'privacy')
├── description (string) → e.g. 'viewed_codice_fiscale'
├── subject_type, subject_id (polymorphic)
├── causer_type, causer_id (chi ha fatto l'azione)
├── properties (json) → dettagli
├── created_at
```

**Configurazione**:

```php
// config/activitylog.php
'default' => 'privacy',
'guard_names' => ['web', 'api'],
```

**Model Observer**:

```php
// Tracciare letture/modifiche PII
class DipendentePIIObserver
{
    public function retrieved(Dipendente $dipendente)
    {
        activity('privacy')
            ->performedOn($dipendente)
            ->event('viewed_pii')
            ->log("Visualizzazione CF: {$dipendente->codice_fiscale}");
    }
}
```

---

### 3.7 CorsoTemplate (Training Catalog)

```
Table: corso_templates
├── id (ULID)
├── mandante_id (ULID, foreign) → Per isolamento multi-tenant
├── titolo (string) → e.g. 'GDPR Fundamentals', 'Privacy by Design'
├── descrizione (text, nullable)
├── validita_mesi (int) → Durata della certificazione (es. 12 mesi)
├── is_obbligatorio (boolean, default: true) → Indica se corso obbligatorio
├── url_risorsa (string, nullable) → Link a materiale, video, etc.
├── status (enum: 'attivo', 'archiviato')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `hasMany('FormazioneDipendente')`

**Scopes**:

- `obbligatori()` → Solo corsi obbligatori
- `attivi()` → Solo status 'attivo'

---

### 3.8 FormazioneDipendente (Training Instances)

```
Table: formazione_dipendentis
├── id (ULID)
├── mandante_id (ULID, foreign) → Per isolamento multi-tenant
├── dipendente_id (ULID, foreign)
├── corso_template_id (ULID, foreign)
├── data_conseguimento (date)
├── data_scadenza (date) → CALCOLATA AUTOMATICAMENTE: data_conseguimento + corso_template.validita_mesi
├── certificato_path (string, nullable) → Media Library reference
├── note (text, nullable)
├── status (enum: 'completato', 'scaduto', 'in_corso')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `belongsTo('Dipendente')`
- `belongsTo('CorsoTemplate')`

**Scopes**:

- `scadute()` → Formazioni con data_scadenza <= today
- `prossimeAScadere()` → Scadenza entro 30 giorni
- `completate()` → Status 'completato'

**Mutators**:

- Quando `data_conseguimento` o `corso_template_id` cambia, **ricalcolare automaticamente** `data_scadenza` in `$casts`:
    ```php
    protected static function booted()
    {
        static::updating(function ($model) {
            if ($model->isDirty('data_conseguimento') || $model->isDirty('corso_template_id')) {
                $corso = $model->corsoTemplate;
                $model->data_scadenza = $model->data_conseguimento
                    ->addMonths($corso->validita_mesi);
            }
        });
    }
    ```

---

### 3.9 CanaleEmail (DPO Communication)

```
Table: canale_emails
├── id (ULID)
├── mandante_id (ULID, foreign) → Per isolamento multi-tenant
├── nome (string) → e.g. 'Privacy Mailbox', 'GDPR Requests'
├── email (string)
├── imap_host (string, encrypted)
├── imap_port (int, default: 993)
├── imap_username (string, encrypted)
├── imap_password (string, encrypted) → Security: SEMPRE criptato
├── encryption_type (enum: 'ssl', 'tls', 'none')
├── last_sync_at (timestamp, nullable) → Ultimo sync riuscito
├── sync_error (text, nullable) → Messaggio errore se sync fallisce
├── parole_chiave_filtro (json, nullable) → ["GDPR", "Privacy", "Diritti", "Consenso"]
├── status (enum: 'attivo', 'inattivo', 'errore')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `hasMany('EmailSincronizzata')`

**Scopes**:

- `attivi()` → Solo status 'attivo'

---

### 3.9bis EmailSincronizzata (Fetched Emails)

```
Table: email_sincronizzates
├── id (ULID)
├── mandante_id (ULID, foreign)
├── canale_email_id (ULID, foreign)
├── email_da (string, encrypted)
├── email_a (string, encrypted)
├── oggetto (string)
├── corpo_preview (text, nullable) → Anteprima (max 500 chars)
├── data_ricezione (timestamp)
├── contiene_keywords (json) → ["GDPR", "Privacy"]
├── status_lettura (enum: 'non_letto', 'letto', 'archiviato')
├── created_at, updated_at
```

**Relations**:

- `belongsTo('Mandante')`
- `belongsTo('CanaleEmail')`

**Scopes**:

- `nonLette()` → Solo non_letto
- `conKeywords()` → Solo email che contengono parole chiave

---

## 4. Plugin & Dipendenze

### 4.1 Authentication & Authorization

**Pacchetti**:

- `filament/spatie-laravel-permission-plugin` (ruoli e permessi in Filament)
- `filament-shield` (generazione automatica di permessi)

**Ruoli Predefiniti**:

- `super_admin` → Accesso globale, tutte le mandanti
- `admin` → Admin di una singola mandante
- `dpo` → Data Protection Officer, accesso audit e report
- `dipendente` → Accesso limitato, solo propri dati

**Policy Pattern**:

```php
class DipendentePolicty
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->mandante_id === $user->mandante()->id;
    }
}
```

---

### 4.2 File Management & Media

**Pacchetto**: `spatie/laravel-medialibrary`

**Utilizzi**:

- Logo Mandante
- Attestati formazione Dipendente
- Documenti (Contratti DPA, Privacy Policy)
- Backup backup di audit log

**Configurazione**:

```php
// app/Models/Mandante.php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mandante extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
```

---

### 4.3 Activity & Audit Logging

**Pacchetto**: `spatie/laravel-activitylog`

**Scopi**:

1. **Compliance**: Tracciare chi accede a PII
2. **Audit Trail**: Storico modifiche per GDPR
3. **Alerts**: Notificare accessi anomali

**Implementazione**:

```php
// config/activitylog.php
'activity_description_prefix' => 'privacyai_',

// app/Models/Concerns/LogsActivity.php
trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            activity('privacy')
                ->performedOn($model)
                ->event('created')
                ->log("Creato {$model->getTable()}: {$model->id}");
        });
    }
}
```

---

### 4.4bis Email Synchronization & DPO Integration

**Pacchetto**: `webklex/laravel-imap`

**Action**: `SyncEmailsAction`

Servizio per il fetching automatico da caselle IMAP e filtraggio per parole chiave:

```php
namespace App\Actions;

use App\Models\CanaleEmail;
use Webklex\IMAP\Facades\Client;

class SyncEmailsAction
{
    public function __invoke(CanaleEmail $canale)
    {
        try {
            // Connessione IMAP
            $client = Client::account($canale->mandante_id);
            $folders = $client->getFolder('INBOX');

            // Fetch emails
            $messages = $folders->query()->all()->get();

            foreach ($messages as $message) {
                $keywords = collect($canale->parole_chiave_filtro ?? [])
                    ->filter(fn ($keyword) =>
                        str_contains($message->getSubject(), $keyword) ||
                        str_contains($message->getTextBody(), $keyword)
                    )
                    ->toArray();

                EmailSincronizzata::create([
                    'mandante_id' => $canale->mandante_id,
                    'canale_email_id' => $canale->id,
                    'email_da' => $message->getFrom()[0]->mail ?? null,
                    'email_a' => $message->getTo()[0]->mail ?? null,
                    'oggetto' => $message->getSubject(),
                    'corpo_preview' => substr($message->getTextBody(), 0, 500),
                    'data_ricezione' => $message->getDate(),
                    'contiene_keywords' => $keywords,
                ]);
            }

            $canale->update(['last_sync_at' => now(), 'status' => 'attivo']);
        } catch (\Exception $e) {
            $canale->update(['sync_error' => $e->getMessage(), 'status' => 'errore']);
        }
    }
}
```

**Job Scheduling**:

```php
// app/Console/Kernel.php
$schedule->job(SyncEmailsJob::class)->everyFiveMinutes();
```

---

### 4.5 PDF Generation & Reports

**Pacchetto**: `barryvdh/laravel-dompdf`

**Report Principali**:

- **Registro Trattamenti**: Elenco software, dipendenti, scadenze
- **Data Breach Log**: Storico accessi anomali
- **Audit Report**: Chi ha accesso a quali dati
- **Attestati Formazione**: Certificati
- **Report Scadenze Formazione**: Formazioni scadute e in scadenza

**Action**:

```php
namespace App\Actions;

class GenerateRegistroTrattamentiAction
{
    public function __invoke(Mandante $mandante): string
    {
        $software = $mandante->software()->get();
        $pdf = PDF::loadView('reports.registro', ['software' => $software]);
        return $pdf->download("Registro_{$mandante->id}.pdf");
    }
}
```

---

### 4.6 Filament UI & Form Components

**Configurazioni speciali**:

#### FormazioneDipendente Form

Implementare `afterStateUpdated` hook per mostrare **data_scadenza prevista in tempo reale**:

```php
// app/Filament/Resources/FormazioneDipendenteResource/Pages/CreateFormazioneDipendente.php

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

DatePicker::make('data_conseguimento')
    ->label(trans('formazione.labels.data_conseguimento'))
    ->required()
    ->afterStateUpdated(function ($state, $set) {
        $corsoId = $this->form->getState()['corso_template_id'] ?? null;
        if ($corsoId && $state) {
            $corso = CorsoTemplate::find($corsoId);
            $scadenza = \Carbon\Carbon::parse($state)->addMonths($corso->validita_mesi);
            $set('data_scadenza', $scadenza);
        }
    }),

Select::make('corso_template_id')
    ->label(trans('formazione.labels.corso'))
    ->relationship('corsoTemplate', 'titolo')
    ->required()
    ->afterStateUpdated(function ($state, $set) {
        $dataConseguimento = $this->form->getState()['data_conseguimento'] ?? null;
        if ($state && $dataConseguimento) {
            $corso = CorsoTemplate::find($state);
            $scadenza = \Carbon\Carbon::parse($dataConseguimento)->addMonths($corso->validita_mesi);
            $set('data_scadenza', $scadenza);
        }
    }),

TextInput::make('data_scadenza')
    ->label(trans('formazione.labels.data_scadenza'))
    ->disabled()
    ->hint('Calcolata automaticamente'),
```

#### CanaleEmail Form

Aggiungere pulsante **"Test Connessione"** per verificare credenziali IMAP:

```php
// app/Filament/Resources/CanaleEmailResource/Pages/CreateCanaleEmail.php

use Filament\Forms\Components\Actions\Action;

TextInput::make('imap_host')
    ->label('IMAP Host')
    ->required()
    ->suffixAction(
        Action::make('test_connection')
            ->label('Test Connessione')
            ->icon('heroicon-o-globe-alt')
            ->action(function ($state) {
                try {
                    // Test IMAP connection
                    $result = app(TestImapConnectionAction::class)($state, ...);
                    Notification::make()
                        ->success()
                        ->title('Connessione Riuscita')
                        ->body('IMAP server raggiungibile')
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title('Connessione Fallita')
                        ->body($e->getMessage())
                        ->send();
                }
            })
    ),
```

#### Scadenze Formazione Dashboard Widget

Mostrare **Formazioni Scadute e Prossime a Scadere** nel dashboard del DPO:

```php
// app/Filament/Widgets/FormazioneScadenzeWidget.php

class FormazioneScadenzeWidget extends ChartWidget
{
    protected static ?string $heading = 'Scadenze Formazione';

    public function getData(): array
    {
        $mandante = auth()->user()->mandante;
        $scadute = $mandante->formazioniDipendenti()->scadute()->count();
        $prossimeAScadere = $mandante->formazioniDipendenti()->prossimeAScadere()->count();

        return [
            'datasets' => [
                [
                    'label' => 'Scadute',
                    'data' => [$scadute],
                    'backgroundColor' => 'rgba(239, 68, 68)',
                ],
                [
                    'label' => 'Prossime a Scadere',
                    'data' => [$prossimeAScadere],
                    'backgroundColor' => 'rgba(234, 179, 8)',
                ],
            ],
        ];
    }
}
```

---

### 4.7 Database Comments & Audit Trail

Aggiungere **commenti MySQL** alle colonne per finalità di audit e compliance:

```php
// database/migrations/xxxx_create_formazione_dipendentis_table.php

$table->date('data_scadenza')
    ->comment('Scadenza calcolata dal sistema: data_conseguimento + corso_template.validita_mesi');

$table->timestamp('last_sync_at')
    ->comment('Ultima sincronizzazione IMAP completata con successo')
    ->nullable();

$table->text('sync_error')
    ->comment('Errore ultima sincronizzazione IMAP - per debug e troubleshooting')
    ->nullable();
```

---

### 4.8 Email Synchronization

**Pacchetto**: `webklex/laravel-imap`

**Job**: `SyncEmailsJob`

```php
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class SyncEmailsJob implements ShouldQueue
{
    public function handle()
    {
        PrivacyEmail::where('sync_enabled', true)->each(function ($privacyEmail) {
            // Connettere IMAP
            // Sincronizzare emails
            // Estrarre allegati (DPIA, consensi)
            // Loggare acceso
        });
    }
}
```

**Scheduling**:

```php
// app/Console/Kernel.php
$schedule->job(SyncPrivacyEmailsJob::class)->dailyAt('02:00');
```

---

## 5. Regole per Copilot (Context Rules)

### 5.1 Filament Components

- **Sempre italiano**: Usa `trans('privacy.labels.mandante')` o stringa italiana diretta
- **Form Fields**: Validare con `Rule::unique('mandantes', 'partita_iva')->ignore($record)`
- **Table Columns**: Nascondere PII di default; mostrare solo con permesso

```php
// Filament Resource
Tables\Columns\TextColumn::make('codice_fiscale')
    ->label(trans('privacy.labels.codice_fiscale'))
    ->visible(fn () => auth()->user()->can('viewPII', $record))
    ->alignCenter(),
```

### 5.2 Policy Checks

Ogni Policy deve includere il check `before()` per super_admin:

```php
public function before(User $user, string $ability): bool|null
{
    if ($user->hasRole('super_admin')) {
        return true;
    }
    return null;
}
```

### 5.3 Testing: Pest PHP

- **Test Files**: `tests/Feature/`, `tests/Unit/`
- **Trait**: `RefreshDatabase` per ogni test
- **Tenant Isolation**: Assicurare che gli utenti di mandante A non accedono a dati di mandante B

```php
// tests/Feature/Dipendente/ViewDipendenteTest.php
it('user can only view employees of their mandante', function () {
    $mandante_a = Mandante::factory()->create();
    $mandante_b = Mandante::factory()->create();

    $user_a = User::factory()->for($mandante_a)->create();
    $dipendente_b = Dipendente::factory()->for($mandante_b)->create();

    $this->actingAs($user_a)
        ->get(route('filament.resources.dipendente.index'))
        ->assertDontSee($dipendente_b->nome);
});
```

### 5.4 Database Seeders

Creare seeders realistici per test/demo:

```php
// database/seeders/MandanteSeeder.php
public function run()
{
    $mandante = Mandante::factory()
        ->has(Dipendente::factory()->count(10))
        ->has(SoftwareFornitore::factory()->count(5))
        ->create();

    User::factory()
        ->for($mandante)
        ->create(['email' => 'admin@mandante.test']);
}
```

### 5.5 Code Structure

```
app/
├── Actions/                    # Action classes per logica business
│   ├── GenerateRegistroTrattamentiAction.php
│   └── SyncPrivacyEmailsAction.php
├── Models/
│   ├── Mandante.php
│   ├── Dipendente.php
│   ├── SoftwareFornitore.php
│   ├── PrivacyEmail.php
│   └── Concerns/
│       └── BelongsToMandante.php
├── Filament/
│   └── Resources/
│       ├── MandanteResource.php
│       ├── DipendenteResource.php
│       └── ...
├── Jobs/
│   └── SyncPrivacyEmailsJob.php
├── Observers/
│   └── DipendenteObserver.php
└── Policies/
    ├── MandantePolicy.php
    ├── DipendentePolicy.php
    └── ...
```

---

## 6. Workflow Development Essenziale

### 6.1 Setup

```bash
composer run setup
php artisan migrate --seed
php artisan filament:install
```

### 6.2 Development

```bash
composer run dev
# Avvia: server, queue listener, logs in tempo reale, Vite watch
```

### 6.3 Testing

```bash
composer run test
# Esegue Pest tests con coverage
```

### 6.4 Generate Documentation

```bash
php artisan docs
# Visualizza laravel.com/docs per API reference
```

---

## 7. Compliance & GDPR

### 7.1 Data Subject Rights

- **Right to Access**: Export dei dati del dipendente via PDF
- **Right to Deletion**: Soft delete con 30-day grace period
- **Right to Rectification**: Audit trail per modifiche
- **Data Portability**: Export in formato machine-readable

### 7.2 Encryption Standard

- All `encrypted` fields usano `Illuminate\Encryption\Encrypter` (AES-256-CBC)
- Chiave in `.env`: `APP_KEY`

### 7.3 Audit Trails

- Ogni accesso a PII loggato in `activity_log`
- Retention: 7 anni (configurabile in `config/activitylog.php`)
- Export: Report giornaliero via email al DPO

---

## 8. Roadmap Features (Future)

- [ ] Two-Factor Authentication (2FA) via TOTP
- [ ] Data Breach Notification Automata (Email + SMS)
- [ ] DPIA Template Generator
- [ ] Third-party Risk Assessment Module
- [ ] Cookie Consent Banner Integration
- [ ] LGPD/CCPA Compliance Mode
- [ ] Webhook integrations per notifiche esterne

---

**Last Updated**: 2026-01-19
**Version**: 1.0
**Maintainers**: Privacy Team
