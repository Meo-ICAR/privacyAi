# Quick Reference: Training & Email Modules

## Documentation Files Reference

### 1. `.github/copilot-instructions.md` (6.6 KB)

**Purpose**: AI Agent guidelines for privacyAi codebase
**Contains**: Architecture patterns, multi-tenancy, conventions, common tasks
**When to use**: Reference for development patterns and standards

---

### 2. `.github/PROJECT_BLUEPRINT.md` (27 KB)

**Purpose**: Comprehensive architecture specification
**Structure**:

- Section 1: Encryption, localization, design patterns
- Section 2: Multi-tenancy via MandanteScope
- Section 3: Data models (all 9 tables including new 4)
    - **3.7**: CorsoTemplate schema
    - **3.8**: FormazioneDipendente schema with auto-calc specs
    - **3.9**: CanaleEmail schema with encrypted fields
    - **3.9bis**: EmailSincronizzata schema
- Section 4: Implementation details
    - **4.4bis**: SyncEmailsAction code
    - **4.6**: Filament UI hooks & patterns
    - **4.7**: MySQL comments guidance
    - **4.8**: Email synchronization workflow

**When to use**: Overall architecture reference, understand auto-calculation logic, Filament UI patterns

---

### 3. `.github/MODELS_EXAMPLE.md` (46 KB, 1689 lines)

**Purpose**: Ready-to-copy PHP code templates
**Structure**:

- **Sections 1-9**: Existing models (Mandante, Mandataria, Dipendente, SubFornitore, etc.)
- **Sections 10-13**: NEW models with complete implementation
    - Section 10: CorsoTemplate model
    - Section 11: FormazioneDipendente model (with booted() auto-calc hook)
    - Section 12: CanaleEmail model (with encrypted casts)
    - Section 13: EmailSincronizzata model (with encrypted casts)
- **Section 14**: Query examples for both modules
- **Section 15**: 4 migration file templates (copy-paste ready)
    - 15.1: `create_corso_templates_table.php`
    - 15.2: `create_formazione_dipendentis_table.php`
    - 15.3: `create_canale_emails_table.php`
    - 15.4: `create_email_sincronizzates_table.php`
- **Section 16**: 4 factory file templates (copy-paste ready)
    - 16.1: CorsoTemplateFactory.php
    - 16.2: FormazioneDipendenteFactory.php
    - 16.3: CanaleEmailFactory.php
    - 16.4: EmailSincronizzataFactory.php

**When to use**: Copy code to implement models, migrations, and factories

---

### 4. `.github/IMPLEMENTATION_SUMMARY.md` (14 KB) ⭐ NEW

**Purpose**: Overview + next steps for implementation
**Contains**:

- Module descriptions
- Auto-calculation logic explanation
- Encryption strategy
- Filament UI features
- Testing requirements
- 7-phase implementation plan with commands
- Approx. 3-4 hours to fully implement

**When to use**: Read first to understand scope, follow checklist for implementation

---

## Key Features Summary

### Module 1: Formazione (Training)

| Feature              | Details                                                                         |
| -------------------- | ------------------------------------------------------------------------------- |
| **Auto-Calculation** | `data_scadenza` = `data_conseguimento` + `CorsoTemplate.validita_mesi` (months) |
| **Where**            | `FormazioneDipendente` model `booted()` hook                                    |
| **Triggers**         | Creating new record OR updating `data_conseguimento` or `corso_template_id`     |
| **Filament**         | afterStateUpdated hook shows live preview of calculated expiry date             |
| **Encryption**       | None (training data non-sensitive)                                              |
| **Scopes**           | `scadute()`, `prossimeAScadere()`, `completate()`                               |

---

### Module 2: Email (DPO Communications)

| Feature         | Details                                                             |
| --------------- | ------------------------------------------------------------------- |
| **Credentials** | Encrypted: `imap_host`, `imap_username`, `imap_password`            |
| **Keywords**    | JSON array: `parole_chiave_filtro` = ["GDPR", "Privacy", ...]       |
| **Sync Logic**  | webklex/laravel-imap → extract keywords → store in DB               |
| **Encryption**  | Email addresses encrypted: `email_da`, `email_a`                    |
| **Filament**    | Test Connection button, keyword tags editor, last sync status badge |
| **Scopes**      | `nonLette()`, `conKeywords()`                                       |
| **Storage**     | All unread emails synced to `EmailSincronizzata` table              |

---

## Critical Code Snippets

### Auto-Calculation (FormazioneDipendente)

```php
protected static function booted()
{
    static::addGlobalScope(new MandanteScope());

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
        if ($model->data_conseguimento && $model->corso_template_id) {
            $corso = CorsoTemplate::find($model->corso_template_id);
            $model->data_scadenza = Carbon::parse($model->data_conseguimento)
                ->addMonths($corso->validita_mesi);
        }
    });
}
```

### Encrypted Fields (CanaleEmail)

```php
protected function casts(): array
{
    return [
        'imap_host' => 'encrypted',           // ⭐ ENCRYPTED
        'imap_username' => 'encrypted',       // ⭐ ENCRYPTED
        'imap_password' => 'encrypted',       // ⭐ ENCRYPTED
        'parole_chiave_filtro' => 'array',    // JSON keywords
        'last_sync_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

### Email Queries

```php
// Get unread emails with keywords
$important = $canale->emailSincronizzate()
    ->nonLette()
    ->conKeywords()
    ->orderBy('data_ricezione', 'desc')
    ->get();

// Filter by specific keyword
$gdpr = $canale->emailSincronizzate()
    ->whereJsonContains('contiene_keywords', 'GDPR')
    ->get();

// Count unread
$count = $canale->emailSincronizzate()->nonLette()->count();
```

---

## Multi-Tenancy Isolation

**All 4 new models** use global scope:

```php
protected static function booted()
{
    static::addGlobalScope(new MandanteScope());
}
```

**Effect**:

- Users automatically see only their mandante's data
- Queries filtered automatically: `where('mandante_id', auth()->user()->mandante_id)`
- Super admin can bypass: `Model::withoutGlobalScopes()->get()`

---

## Testing Strategy

### Unit Tests (Pest PHP)

```php
// Test auto-calculation
it('calculates data_scadenza correctly', function () {
    $corso = CorsoTemplate::factory(['validita_mesi' => 6])->create();
    $formazione = FormazioneDipendente::factory([
        'corso_template_id' => $corso->id,
        'data_conseguimento' => '2026-01-19',
    ])->create();

    expect($formazione->data_scadenza->format('Y-m-d'))
        ->toBe('2026-07-19'); // +6 months
});

// Test keyword filtering
it('filters emails by keywords', function () {
    $canale = CanaleEmail::factory()->create();
    $email = EmailSincronizzata::factory([
        'canale_email_id' => $canale->id,
        'contiene_keywords' => ['GDPR', 'Privacy'],
    ])->create();

    expect($canale->emailSincronizzate()->conKeywords()->count())->toBe(1);
});
```

---

## Implementation Phases (Quick Overview)

| Phase     | Task                                               | Time          |
| --------- | -------------------------------------------------- | ------------- |
| 1         | Create 4 model files from MODELS_EXAMPLE           | 30 min        |
| 2         | Copy 4 migration files                             | 15 min        |
| 3         | Copy 4 factory files                               | 20 min        |
| 4         | Run migrations & test basic queries                | 15 min        |
| 5         | Generate Filament resources                        | 45 min        |
| 6         | Create SyncEmailsAction + TestImapConnectionAction | 30 min        |
| 7         | Create SyncDpoEmailsJob scheduled command          | 15 min        |
| **TOTAL** | Complete implementation                            | **3-4 hours** |

---

## File Locations in Laravel App

### Models

```
app/Models/
├── CorsoTemplate.php          ← NEW
├── FormazioneDipendente.php   ← NEW
├── CanaleEmail.php            ← NEW
└── EmailSincronizzata.php     ← NEW
```

### Migrations

```
database/migrations/
├── 0001_01_01_000200_create_corso_templates_table.php
├── 0001_01_01_000201_create_formazione_dipendentis_table.php
├── 0001_01_01_000202_create_canale_emails_table.php
└── 0001_01_01_000203_create_email_sincronizzates_table.php
```

### Factories

```
database/factories/
├── CorsoTemplateFactory.php
├── FormazioneDipendenteFactory.php
├── CanaleEmailFactory.php
└── EmailSincronizzataFactory.php
```

### Actions (Business Logic)

```
app/Actions/
├── SyncEmailsAction.php          ← webklex/laravel-imap integration
└── TestImapConnectionAction.php  ← connection validation for Filament
```

### Filament Resources

```
app/Filament/Resources/
├── CorsoTemplateResource.php
├── FormazioneDipendenteResource.php
├── CanaleEmailResource.php
└── EmailSincronizzataResource.php
```

---

## Migration Path from Documentation

1. **Understand the architecture** → Read `IMPLEMENTATION_SUMMARY.md`
2. **Learn the models** → Review `MODELS_EXAMPLE.md` sections 10-13
3. **Understand queries** → Check `MODELS_EXAMPLE.md` section 14
4. **Copy code** → Use sections 15-16 for migrations & factories
5. **Implement Filament** → Follow `PROJECT_BLUEPRINT.md` section 4.6
6. **Test** → Run queries from section 14 in Tinker

---

## Key Dates & Versions

- **Created**: 2026-01-19
- **Documentation Version**: 1.2
- **Laravel Version**: 12.47.0
- **Filament Version**: 5.0.0
- **Expected Completion**: Within 1 week of implementation start

---

## Support Documents

| Doc                       | Purpose              | Location   |
| ------------------------- | -------------------- | ---------- |
| copilot-instructions.md   | AI coding guidelines | `.github/` |
| PROJECT_BLUEPRINT.md      | Architecture spec    | `.github/` |
| MODELS_EXAMPLE.md         | Code templates       | `.github/` |
| IMPLEMENTATION_SUMMARY.md | Implementation plan  | `.github/` |
| **THIS FILE**             | Quick reference      | `.github/` |

---

✅ **All documentation complete and ready for implementation!**
