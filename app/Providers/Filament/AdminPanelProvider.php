<?php

namespace App\Providers\Filament;

use App\Models\Mandante;  // Assicurati di importarlo
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('PrivacyAI')
            ->favicon('images/privacyai_icona.ico')
            // 2. Il Logo (per la sidebar e la pagina di login)
            ->brandLogo(asset('images/privacyai_logo.png'))
            // 3. L'Icona (Favicon del browser)
            ->favicon(asset('images/privacy_icona.png'))
            // 4. Altezza del logo (Opzionale, default è circa 2rem)
            ->brandLogoHeight('3rem')
            ->tenant(Mandante::class, slugAttribute: 'id')
            // Indica a Filament quale colonna usare per lo slug nell'URL (opzionale)
            //   ->tenantDomain('{tenant:slug}.privacyai.test')  // Se usi i sottodomini
            //   ->tenantRoutePrefix('client')  // URL diventerà: /admin/client/{id}/...
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                \DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin::make()
                    ->providers([
                        \DutchCodingCompany\FilamentSocialite\Provider::make('google')
                            ->label('Google')
                            ->icon('fab-google')
                            ->color(\Filament\Support\Colors\Color::hex('#db4437'))
                            ->outlined(false)
                            ->stateless(false),
                        \DutchCodingCompany\FilamentSocialite\Provider::make('microsoft')
                            ->label('Microsoft')
                            ->icon('fab-microsoft')
                            ->color(\Filament\Support\Colors\Color::hex('#00a4ef'))
                            ->outlined(false)
                            ->stateless(false),
                        \DutchCodingCompany\FilamentSocialite\Provider::make('linkedin')
                            ->label('LinkedIn')
                            ->icon('fab-linkedin')
                            ->color(\Filament\Support\Colors\Color::hex('#0077b5'))
                            ->outlined(false)
                            ->stateless(false),
                    ])
                    ->slug('admin')
                    ->registration(true)
                    ->userModelClass(\App\Models\User::class)
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
