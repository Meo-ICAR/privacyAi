---
description: Repository Information Overview
alwaysApply: true
---

# privacyAi Information

## Summary
**privacyAi** is a Laravel 12.47 multi-tenant application designed for comprehensive data management across multiple business domains (Invoicing, HR, Real Estate, CRM). It leverages **Filament 4/5** for a robust admin UI and **Livewire 4** for reactive components. The system features strict tenant isolation using a **Mandante** (client) architecture, where users and data are scoped via the `BelongsToMandante` trait. It includes localized support for Italian and English.

## Structure
- **app/Filament**: Contains Filament resources, pages, and relation managers for the admin panel.
- **app/Models**: Domain-specific Eloquent models (Audit, CRM, HR, Invoicing, etc.) with ULID primary keys.
- **app/Traits**: Houses the `BelongsToMandante` trait for multi-tenant scoping.
- **database/migrations**: Database schema definitions with numeric prefixes.
- **lang/**: Localization files for Italian (`it`) and English (`en`).
- **resources/js & resources/css**: Frontend assets using Vite and Tailwind CSS v4.
- **routes/**: Web and console route definitions.
- **tests/**: Feature and Unit test suites using PHPUnit.

## Language & Runtime
**Language**: PHP  
**Version**: ^8.2 (Laravel ^12.0)  
**Build System**: Vite ^7.0.7  
**Package Manager**: Composer (PHP), NPM (JS)

## Dependencies
**Main Dependencies**:
- **filament/filament**: Admin panel framework (^4.0)
- **laravel/framework**: Core web framework (^12.0)
- **laravel/cashier**: Subscription billing management
- **spatie/laravel-medialibrary**: Media management
- **spatie/laravel-permission**: RBAC and permissions
- **spatie/laravel-activitylog**: Audit logging
- **webklex/laravel-imap**: Email integration
- **barryvdh/laravel-dompdf**: PDF generation

**Development Dependencies**:
- **laravel/sail**: Docker development environment
- **laravel/pail**: Real-time log monitoring
- **phpunit/phpunit**: Testing framework
- **tailwindcss**: Styling (^4.0)
- **vite**: Asset bundling (^7.0)

## Build & Installation
```bash
# Full initialization (Install, env, key, migrate, npm build)
composer run setup

# Start development server, queue listener, logs, and Vite
composer run dev
```

## Testing
**Framework**: PHPUnit  
**Test Location**: `tests/Feature` and `tests/Unit`  
**Naming Convention**: `*Test.php`  
**Configuration**: `phpunit.xml`  

**Run Command**:
```bash
composer run test
```

## Project Patterns
- **Multi-Tenancy**: Tenant isolation is enforced at the model level via `BelongsToMandante`.
- **Primary Keys**: Uses **ULIDs** instead of auto-incrementing IDs for better distributed systems support.
- **Domain Modules**:
    - **HR/Compensation**: `Dipendente`, `Corso`, `Mansione`.
    - **Invoicing/Legal**: `AuditRequest`, `AuditFornitori`, `BasiGiuridiche`.
    - **Multi-Entity Relationships**: Mandante → Mandataria → SubFornitore hierarchy.
- **Localization**: Carbon and application locale defaults to Italian (`it`).
