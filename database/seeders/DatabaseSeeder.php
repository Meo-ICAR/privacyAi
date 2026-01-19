<?php

namespace Database\Seeders;

use App\Models\Mandante;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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

        // 2. Creazione del Super-Admin e Tenant di Default

        // 2a. Assicuriamoci che esista il ruolo super_admin
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 2b. Creiamo un Tenant di default (necessario per Filament)
        $mandante = Mandante::firstOrCreate(
            ['p_iva' => '00000000000'],
            [
                'ragione_sociale' => 'PrivacyCall S.r.l.',
                'titolare_trattamento' => 'Mario Rossi',
                'email_referente' => 'admin@privacycall.it',
                'is_active' => true,
            ]
        );

        // 2c. Creiamo o aggiorniamo l'utente Admin
        $user = User::firstOrCreate(
            ['email' => 'admin@privacycall.it'],
            [
                'name' => 'DPO Super Admin',
                'password' => Hash::make('password'),
                'mandante_id' => $mandante->id,
            ]
        );

        // Assicuriamoci che l'utente sia collegato al tenant e abbia il ruolo
        if ($user->mandante_id !== $mandante->id) {
            $user->mandante_id = $mandante->id;
            $user->save();
        }

        if (! $user->hasRole('super_admin')) {
            $user->assignRole($role);
        }

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
