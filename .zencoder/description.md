# PrivacyAi Project Environment

## Core Stack
- **Framework**: Laravel 12.0
- **Admin UI**: Filament 4 (configured with Multi-tenancy)
- **Interactive UI**: Livewire 4
- **Language**: PHP 8.2+
- **Frontend**: Tailwind CSS 4, Vite 7
- **Database**: MariaDB (Production), SQLite (Testing/Development). Tables use ULID as primary keys.

## Architecture & Patterns
- **Multi-tenancy**: 
    - Managed via Filament's native tenant support in `AdminPanelProvider.php:31`.
    - Tenant model is `App\Models\Mandante`.
    - Data isolation is enforced via the `BelongsToMandante` trait (`app/Traits/BelongsToMandante.php` and `app/Models/Concerns/BelongsToMandante.php`), which applies a global scope `mandante_isolation`.
- **Primary Keys**: ULID system via `Illuminate\Database\Eloquent\Concerns\HasUlids`.
- **Localization**: Default Italian (`it`) and English (`en`). `AppServiceProvider` sets Carbon locale to `it`.
- **RBAC**: Spatie Permission (`HasRoles` trait in `User` model).

## Modules & Domain Logic
- **Core (Mandante/Mandataria/SubFornitore)**:
    - `Mandante`: The primary tenant/client.
    - `Mandataria`: Service providers.
    - `Fornitori`: Third-party vendors.
    - `Dipendenti`: Employee management with relationships to Mandante, Filiali, and Fornitori.
- **Audit & Compliance**:
    - `AuditRequest`, `AuditExport`, `AuditFornitori`, `AuditSezioni`.
    - `RegistroTrattamenti`, `BasiGiuridiche`, `MisuraSicurezza`.
- **HR & Training**:
    - `Corso`, `CorsoTemplate`, `FormazioneDipendenti`.
- **Communication & Marketing**:
    - `EmailProvider`, `EmailTemplate`, `CanaliEmail`.
    - `SitiWeb`.
- **Legal & DPO**:
    - `DpoAnagrafica`, `ServiziDpo`.
- **Subscriptions**:
    - `Subscription`, `SubscriptionItem` (Laravel Cashier integration).

## Key Integrations & Packages
- **Spatie**: Media Library (`InteractsWithMedia`), Activity Log, Permissions.
- **Filament Plugins**: Excel Import, Excel Export (pxlrbt/filament-excel).
- **Invoicing/Reports**: DomPDF.
- **Communication**: Laravel IMAP (`webklex/laravel-imap`).
- **Payments**: Laravel Cashier.

## Development Workflow
- **Setup**: `composer run setup`
- **Dev**: `composer run dev` (starts server, queue, logs, and Vite)
- **Test**: `composer run test` (PHPUnit)
- **Logs**: Laravel Pail via `php artisan pail`
