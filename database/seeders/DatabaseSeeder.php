<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tabelle Globali (Configurazioni di Sistema)
        // Queste tabelle non dipendono da nessuno e sono condivise tra tutti i tenant.
        $this->call([
            EmailProviderSeeder::class,  // Configurazione IMAP/OAuth2
            CorsoTemplateSeeder::class,  // Catalogo corsi di formazione standard
            AuditProfessionalSeeder::class,  // La checklist con 60+ controlli
            EmailTemplateSeeder::class,  // I template per le notifiche
            DocumentoTipoSeeder::class,
            MisuraSicurezzaSeeder::class,
            MansioneSeeder::class,  // Catalogo ruoli e rischi privacy
        ]);

        // 2. Creazione del Super-Admin (DPO Globale)
        // Questo utente non appartiene a nessun mandante specifico (mandante_id = null)

        User::factory()->create([
            'name' => 'DPO Super Admin',
            'email' => 'admin@privacycall.it',
            'password' => Hash::make('password'),  // Ricorda di cambiarla!
            'mandante_id' => null,
        ]);

        // 3. Esempio di Struttura Tenant (Dati di Test)
        // Se hai creato i seeder specifici, scommentali qui sotto.
        // L'ordine è: Mandante -> Filiali/Mandatarie -> Dipendenti -> Formazione

        /*
         * $this->call([
         *     MandanteSeeder::class,
         *     FilialeSeeder::class,
         *     MandatariaSeeder::class,
         *     DipendenteSeeder::class,
         *     CanaleEmailSeeder::class,
         * ]);
         */
    }
}
