<?php

namespace Database\Seeders;

use App\Models\DataBreach;
use App\Models\Mandante;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataBreachSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $mandante = Mandante::first();

        if (!$mandante) {
            $this->command->warn('Nessun Mandante trovato. Crea prima un Mandante.');
            return;
        }

        // Violazione 1: Accesso non autorizzato (Chiusa)
        DataBreach::create([
            'mandante_id' => $mandante->id,
            'description' => 'Accesso non autorizzato al database clienti da parte di un ex dipendente. Compromessi circa 150 record contenenti nome, email e numero di telefono.',
            'occurred_at' => Carbon::now()->subDays(45),
            'detected_at' => Carbon::now()->subDays(44),
            'is_notified_authority' => true,
            'authority_notified_at' => Carbon::now()->subDays(43),
            'is_notified_subjects' => true,
            'subjects_notified_at' => Carbon::now()->subDays(42),
            'risk_level' => 'medium',
            'status' => 'closed',
            'notes' => 'Violazione risolta. Revocate credenziali ex dipendente. Implementato sistema di monitoraggio accessi. Nessun danno rilevato agli interessati.',
        ]);

        // Violazione 2: Ransomware (In indagine)
        DataBreach::create([
            'mandante_id' => $mandante->id,
            'description' => 'Attacco ransomware che ha cifrato server contenente dati di fatturazione. Potenzialmente compromessi dati economici e anagrafici di 500+ clienti.',
            'occurred_at' => Carbon::now()->subDays(15),
            'detected_at' => Carbon::now()->subDays(14),
            'is_notified_authority' => true,
            'authority_notified_at' => Carbon::now()->subDays(13),
            'is_notified_subjects' => false,
            'subjects_notified_at' => null,
            'risk_level' => 'high',
            'status' => 'investigating',
            'notes' => 'In corso analisi forense. Backup ripristinato. Valutazione in corso sull\'effettiva esfiltrazione dei dati. Polizia Postale informata.',
        ]);

        // Violazione 3: Email errata (Basso rischio, Aperta)
        DataBreach::create([
            'mandante_id' => $mandante->id,
            'description' => 'Invio accidentale di email contenente dati personali di un cliente ad un destinatario errato. Coinvolto 1 solo interessato.',
            'occurred_at' => Carbon::now()->subDays(3),
            'detected_at' => Carbon::now()->subDays(3),
            'is_notified_authority' => false,
            'authority_notified_at' => null,
            'is_notified_subjects' => true,
            'subjects_notified_at' => Carbon::now()->subDays(2),
            'risk_level' => 'low',
            'status' => 'open',
            'notes' => 'Destinatario errato contattato e confermata cancellazione email. Interessato informato. Rischio valutato come basso, non richiesta notifica al Garante.',
        ]);

        // Violazione 4: Furto laptop (Critico, Aperto)
        DataBreach::create([
            'mandante_id' => $mandante->id,
            'description' => 'Furto di laptop aziendale contenente database non cifrato con dati sanitari di 200 pazienti. Include diagnosi, terapie e dati anagrafici completi.',
            'occurred_at' => Carbon::now()->subDays(2),
            'detected_at' => Carbon::now()->subDays(1),
            'is_notified_authority' => true,
            'authority_notified_at' => Carbon::now()->subHours(12),
            'is_notified_subjects' => false,
            'subjects_notified_at' => null,
            'risk_level' => 'critical',
            'status' => 'open',
            'notes' => 'URGENTE: Dati sanitari (Art. 9 GDPR). Garante notificato entro 72h. Denuncia presentata. Preparazione comunicazione agli interessati in corso. Implementazione policy cifratura obbligatoria su tutti i dispositivi.',
        ]);

        // Violazione 5: Phishing dipendente (Medio, In indagine)
        DataBreach::create([
            'mandante_id' => $mandante->id,
            'description' => 'Dipendente vittima di attacco phishing ha fornito credenziali di accesso al sistema HR. Possibile accesso a dati di 80 dipendenti.',
            'occurred_at' => Carbon::now()->subDays(7),
            'detected_at' => Carbon::now()->subDays(6),
            'is_notified_authority' => true,
            'authority_notified_at' => Carbon::now()->subDays(5),
            'is_notified_subjects' => false,
            'subjects_notified_at' => null,
            'risk_level' => 'medium',
            'status' => 'investigating',
            'notes' => 'Credenziali immediatamente revocate. Analisi log in corso per verificare accessi effettivi. Formazione anti-phishing programmata per tutto il personale.',
        ]);

        $this->command->info('Creati 5 esempi di violazioni dati');
    }
}
