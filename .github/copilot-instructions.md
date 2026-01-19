# AI Coding Agent Guidelines for privacyAi

## Project Overview

**privacyAi** is a Laravel 12.47 application with Italian localization, using Filament 5 for admin UI and Livewire 4 for interactive components. The system manages multi-tenant data with a **mandante** (client/tenant) architecture—users belong to clients via the `BelongsToMandante` trait, establishing tenant isolation at the model level.

**Database**: MariaDB with 150+ tables including domain-specific schemas (invoicing, HR, real estate, CRM modules).

## Architecture Patterns

### Tenant Isolation via BelongsToMandante Trait

- Located in `app/Traits/` (though not currently visible, referenced in User model)
- All user-scoped models must use this trait to automatically filter by `mandante_id`
- When creating queries for users, **always** scope to the tenant: never assume global data access
- Example: `User::where('mandante_id', auth()->user()->mandante_id)->get()`

### Multi-Module Design

The database reveals distinct business domains:

- **Invoicing**: `fatturas`, `invoices`, `proformas`, `provvigioni`
- **HR/Compensation**: `dipendentis`, `stipendis`, `compensos`, `enasarcotots`
- **Real Estate/Land**: `terreni`, `possessi`, `fabbricati`
- **CRM**: `leads`, `calls`, `shortlists`
- **Projects**: `projects`, `project_roles`, `project_services`

Each module has distinct business logic—avoid coupling them. Generate models/resources independently per domain.

## Development Workflow

### Key Commands

- **Development**: `composer run dev` — starts server, queue listener, logs, and Vite in parallel
- **Testing**: `composer run test` — clears config and runs PHPUnit (Unit + Feature suites)
- **Setup**: `composer run setup` — full initialization (install, env, key, migrate, npm build)
- **Tinker**: `php artisan tinker` — test code interactively

### Localization

- Italian (`it`) and English (`en`) language files in `lang/`
- `AppServiceProvider` sets Carbon locale to Italian: `\Carbon\Carbon::setLocale('it')`
- **Always** include translations in both `lang/it/` and `lang/en/` when adding user-facing strings

### Database

- Uses ULID primary keys via `HasUlids` concern (not auto-incrementing IDs)
- Migrations in `database/migrations/` with numeric prefixes (0001, 0002, etc.)
- Testing uses SQLite in-memory DB (configured in `phpunit.xml`)
- For queries: prefer Eloquent with scopes over raw SQL; leverage lazy loading for relationships

### Multi-Entity Relationships (Mandante → Mandataria → SubFornitore)

The application has a three-tier vendor management hierarchy:

- **Mandante** (primary client) → contracts with multiple Mandatarie
- **Mandataria** (service providers: telcos, etc.) → contracts with multiple SubFornitori
- **SubFornitore** (third-party vendors: call centers, software houses, external staff)

Each relationship is **many-to-many** with pivot tables containing collaboration metadata:

- `mandante_mandataries`: service contracts, dates, status
- `mandataria_subfornitori`: resource count, collaboration status, contract references

Always validate **unique constraints** on pivot tables to prevent duplicate relationships.

## Conventions & Patterns

### Model Structure

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids, BelongsToMandante;

    protected $fillable = ['mandante_id', 'name', 'email', 'password'];

    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
}
```

- Always define `$fillable` explicitly (mass assignment guard)
- Use type-hinted `casts()` method (not static `$casts`)
- Use `HasUlids` for all new models unless legacy ID exists

### Filament Integration

- This is a **Filament 5** admin panel application—most UI interactions go through Filament resources
- Use `filament:make-resource` to scaffold resources with tables/forms
- Filament resources auto-generate pages; follow the resource + relation manager pattern
- Tables use `Filament\Tables` components; forms use `Filament\Forms`

### Testing Setup

- **Unit tests**: `tests/Unit/` — isolated logic, use factories
- **Feature tests**: `tests/Feature/` — integration tests with database
- Test database is SQLite in-memory; migrations run fresh before each test suite
- Use `UserFactory` (in `database/factories/`) to create test data

### Frontend Stack

- **Vite** (v7) for asset bundling; configured in `vite.config.js`
- **Tailwind CSS** v4 with `@tailwindcss/vite` plugin
- **Livewire** 4.0 for reactive components (already included)
- Resources in `resources/css/app.css` and `resources/js/app.js`
- Run `npm run dev` for watch mode; `npm run build` for production

### Package Ecosystem

- **Filament**: Admin UI framework (5.0)
- **Livewire**: Reactive component framework (4.0)
- **Spatie Packages**: Activity logging, media library, permissions, RBAC
- **Laravel IMAP**: Email integration (`webklex/laravel-imap`)
- **DomPDF**: PDF generation (`barryvdh/laravel-dompdf`)
- **Activity Log**: Auto-tracks model changes via `spatie/laravel-activitylog`

## Common Tasks

### Adding a New Feature

1. Create migration: `php artisan make:migration create_feature_table`
2. Create model: `php artisan make:model Feature -m` (includes migration)
3. Apply `BelongsToMandante` trait if user-scoped
4. Create Filament resource: `php artisan filament:make-resource Feature`
5. Add tests: `php artisan make:test FeatureTest --feature`

### Querying with Tenancy

```php
// Always scope to current tenant
Feature::where('mandante_id', auth()->user()->mandante_id)->get();

// Or use scope (if defined in model)
Feature::forMandante(auth()->user()->mandante_id)->get();
```

### Running Async Jobs

- Queue connection configured in `config/queue.php`
- In development: jobs run via `php artisan queue:listen` (started by `composer run dev`)
- Dispatch jobs: `YourJob::dispatch($data)->onQueue('default')`

## Debugging & Tools

- **Laravel Pail**: `php artisan pail` (real-time logs; included in dev stack)
- **Laravel Tinker**: Interactive shell for testing queries and code
- **Database**: `php artisan db:show` for schema overview
- **Routes**: `php artisan route:list` to view all registered routes
- **Artisan**: Run `php artisan list` for full command inventory

## When Unsure

- **Check existing models** in `app/Models/` for patterns (scope usage, relationships, casts)
- **Review migrations** in `database/migrations/` for schema structure
- **Look at tests** in `tests/` for expected behavior and test patterns
- **Read Filament docs** for UI component specifics (resources, tables, forms)
- **Use tinker** to interactively test queries before baking into code
