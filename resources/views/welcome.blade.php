<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>privacyAi - Gestione Privacy Intelligente</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Inter', sans-serif;
            }

            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .feature-icon {
                transition: transform 0.3s ease;
            }

            .card-hover:hover .feature-icon {
                transform: scale(1.1);
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }

            .floating {
                animation: float 6s ease-in-out infinite;
            }

            .glassmorphism {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-2xl font-bold gradient-text">privacyAi</span>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/admin') }}" class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors">
                                    Accedi
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                                        Inizia Gratis
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 gradient-bg">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-white">
                        <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                            Gestione Privacy<br>
                            <span class="text-cyan-300">Intelligente e Sicura</span>
                        </h1>
                        <p class="text-xl text-purple-100 mb-8 leading-relaxed">
                            La soluzione completa per la conformità GDPR. Multi-tenant, sicura, e progettata per semplificare la gestione della privacy aziendale.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <a href="{{ url('/admin') }}" class="px-8 py-4 text-lg font-semibold text-purple-600 bg-white rounded-lg hover:bg-gray-50 transition-all shadow-xl hover:shadow-2xl text-center">
                                    Vai al Dashboard
                                </a>
                            @else
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-semibold text-purple-600 bg-white rounded-lg hover:bg-gray-50 transition-all shadow-xl hover:shadow-2xl text-center">
                                        Inizia Ora
                                    </a>
                                @endif
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-purple-700 to-indigo-700 rounded-lg hover:from-purple-800 hover:to-indigo-800 transition-all shadow-xl hover:shadow-2xl text-center">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Accedi
                                    </a>
                                @endif
                            @endauth
                            <a href="#features" class="px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-lg hover:bg-white hover:text-purple-600 transition-all text-center">
                                Scopri di Più
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-purple-400/30">
                            <div>
                                <div class="text-3xl font-bold text-cyan-300">150+</div>
                                <div class="text-sm text-purple-200">Tabelle Database</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-cyan-300">100%</div>
                                <div class="text-sm text-purple-200">GDPR Compliant</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-cyan-300">24/7</div>
                                <div class="text-sm text-purple-200">Monitoraggio</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="floating">
                            <img src="{{ asset('images/hero-illustration.png') }}" alt="Privacy Management Illustration" class="w-full h-auto rounded-2xl shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        Funzionalità <span class="gradient-text">Avanzate</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Tutto ciò di cui hai bisogno per gestire la privacy in modo professionale
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Crittografia Avanzata</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Tutti i dati sensibili (CF, P.IVA, credenziali IMAP) sono crittografati con algoritmi di sicurezza enterprise-grade.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-Tenancy</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Isolamento completo dei dati per ogni mandante. Gestisci più organizzazioni con sicurezza totale.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Gestione Formazione</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Traccia corsi privacy, scadenze automatiche e certificazioni per dipendenti e fornitori.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Sincronizzazione Email</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Integrazione IMAP per monitorare richieste GDPR e comunicazioni DPO con filtri intelligenti.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Audit Trail Completo</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Tracciamento automatico di ogni accesso ai dati PII per conformità e sicurezza.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="card-hover p-8 bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="feature-icon w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Filament 5 UI</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Interfaccia moderna e intuitiva basata su Filament per una gestione efficiente e piacevole.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tech Stack Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        Stack Tecnologico <span class="gradient-text">Moderno</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Costruito con le migliori tecnologie per performance e sicurezza
                    </p>
                </div>

                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow">
                        <div class="text-4xl font-bold text-red-600 mb-2">Laravel 12</div>
                        <div class="text-gray-600">Framework PHP</div>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow">
                        <div class="text-4xl font-bold text-amber-500 mb-2">Filament 5</div>
                        <div class="text-gray-600">Admin Panel</div>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow">
                        <div class="text-4xl font-bold text-purple-600 mb-2">Livewire 4</div>
                        <div class="text-gray-600">Reactive UI</div>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow">
                        <div class="text-4xl font-bold text-blue-600 mb-2">MySQL 8</div>
                        <div class="text-gray-600">Database</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 gradient-bg">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6">
                    Pronto a Semplificare la Gestione Privacy?
                </h2>
                <p class="text-xl text-purple-100 mb-8 leading-relaxed">
                    Inizia oggi con privacyAi e porta la conformità GDPR al livello successivo
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-block px-10 py-4 text-lg font-semibold text-purple-600 bg-white rounded-lg hover:bg-gray-50 transition-all shadow-2xl hover:shadow-3xl">
                        Inizia Gratis Ora
                    </a>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 text-gray-300">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-xl font-bold text-white">privacyAi</span>
                        </div>
                        <p class="text-sm text-gray-400">
                            Gestione Privacy Intelligente per la conformità GDPR
                        </p>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Prodotto</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#features" class="hover:text-purple-400 transition-colors">Funzionalità</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Prezzi</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Documentazione</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Azienda</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Chi Siamo</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Contatti</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Legale</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Termini di Servizio</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">GDPR</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} privacyAi. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
