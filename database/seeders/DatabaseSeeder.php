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
            AziendaTipoSeeder::class,
            ServiziDpoSeeder::class,
            DpoAnagraficaSeeder::class,
            BasiGiuridicheSeeder::class,
            HoldingsTableSeeder::class,
            NormativaSeeder::class,  // Normativa e compliance per fornitori
        ]);

        // 2. Architettura Multi-Tenant e Dati di Esempio

        $this->call([
            HoldingSeeder::class,
            MandanteSeeder::class,
            MandantiSeeder::class,
        ]);

        // 2a. Assicuriamoci che esista il ruolo super_admin
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // 2b. Recuperiamo o creiamo un mandante di riferimento
        $mandante = Mandante::where('p_iva', '00000000000')->first() ?? Mandante::first();

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

        if (!$user->hasRole('super_admin')) {
            $user->assignRole($role);
        }

        // 3. Dati Operativi Tenant-Scoped (Dati di Test)
        $this->call([
            FilialiSeeder::class,
            MandatariaSeeder::class,
            FornitoriSeeder::class,
            DipendentiSeeder::class,
            FormazioneDipendentiSeeder::class,
            CanaleEmailSeeder::class,
            SitiWebSeeder::class,
            RolesAndUsersSeeder::class,
        ]);
    }
}
