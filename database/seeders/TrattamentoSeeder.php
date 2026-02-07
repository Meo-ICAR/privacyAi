<?php

namespace Database\Seeders;

use App\Models\Trattamento;
use App\Models\Mandante;
use App\Models\CategoriaDati;
use Illuminate\Database\Seeder;

class TrattamentoSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Ottieni il primo mandante per gli esempi
        $mandante = Mandante::first();

        if (!$mandante) {
            $this->command->warn('Nessun Mandante trovato. Crea prima un Mandante.');
            return;
        }

        // Ottieni alcune categorie di dati
        $datiAnagrafici = CategoriaDati::where('nome', 'Dati Anagrafici')->first();
        $datiContatto = CategoriaDati::where('nome', 'Dati di Contatto')->first();
        $datiEconomici = CategoriaDati::where('nome', 'Dati Economici')->first();
        $datiProfessionali = CategoriaDati::where('nome', 'Dati Professionali')->first();

        // Trattamento 1: Gestione Risorse Umane
        $trattamento1 = Trattamento::create([
            'mandante_id' => $mandante->id,
            'nome' => 'Gestione Risorse Umane',
            'descrizione' => 'Trattamento dei dati dei dipendenti per la gestione amministrativa del personale',
            'finalita' => 'Gestione del rapporto di lavoro, adempimenti contrattuali, fiscali e previdenziali',
            'categorie_interessati' => 'Dipendenti, collaboratori, stagisti',
            'base_giuridica' => 'Art. 6(1)(b) GDPR - Esecuzione di un contratto; Art. 6(1)(c) GDPR - Obbligo legale',
            'destinatari' => 'Consulenti del lavoro, commercialisti, INPS, Agenzia delle Entrate',
            'trasferimenti_extra_ue' => 'Nessuno',
            'termini_conservazione' => '10 anni dalla cessazione del rapporto di lavoro (obblighi fiscali)',
            'misure_sicurezza' => 'Accesso limitato tramite credenziali, backup giornalieri, cifratura dei dati sensibili',
            'is_active' => true,
        ]);

        if ($datiAnagrafici && $datiContatto && $datiEconomici && $datiProfessionali) {
            $trattamento1->categorieDati()->attach([
                $datiAnagrafici->id,
                $datiContatto->id,
                $datiEconomici->id,
                $datiProfessionali->id,
            ]);
        }

        // Trattamento 2: Marketing Diretto
        $trattamento2 = Trattamento::create([
            'mandante_id' => $mandante->id,
            'nome' => 'Marketing Diretto',
            'descrizione' => 'Invio di comunicazioni commerciali e promozionali ai clienti',
            'finalita' => 'Promozione di prodotti e servizi, fidelizzazione clienti',
            'categorie_interessati' => 'Clienti, prospect, utenti registrati',
            'base_giuridica' => 'Art. 6(1)(a) GDPR - Consenso dell\'interessato',
            'destinatari' => 'Piattaforme di email marketing (es. Mailchimp), agenzie di comunicazione',
            'trasferimenti_extra_ue' => 'USA - Clausole Contrattuali Standard',
            'termini_conservazione' => '2 anni dall\'ultimo contatto o fino a revoca del consenso',
            'misure_sicurezza' => 'Cifratura delle comunicazioni, opt-out automatico, registro consensi',
            'is_active' => true,
        ]);

        if ($datiAnagrafici && $datiContatto) {
            $trattamento2->categorieDati()->attach([
                $datiAnagrafici->id,
                $datiContatto->id,
            ]);
        }

        // Trattamento 3: Gestione Clienti
        $trattamento3 = Trattamento::create([
            'mandante_id' => $mandante->id,
            'nome' => 'Gestione Clienti (CRM)',
            'descrizione' => 'Gestione delle relazioni con i clienti e tracciamento delle interazioni commerciali',
            'finalita' => 'Esecuzione contratti di vendita, assistenza clienti, analisi delle preferenze',
            'categorie_interessati' => 'Clienti attuali e potenziali',
            'base_giuridica' => 'Art. 6(1)(b) GDPR - Esecuzione di un contratto; Art. 6(1)(f) GDPR - Legittimo interesse',
            'destinatari' => 'Fornitori di servizi CRM, corrieri, istituti di credito',
            'trasferimenti_extra_ue' => 'Nessuno',
            'termini_conservazione' => '10 anni per obblighi fiscali, 5 anni per dati commerciali',
            'misure_sicurezza' => 'Autenticazione a due fattori, log degli accessi, backup incrementali',
            'is_active' => true,
        ]);

        if ($datiAnagrafici && $datiContatto && $datiEconomici) {
            $trattamento3->categorieDati()->attach([
                $datiAnagrafici->id,
                $datiContatto->id,
                $datiEconomici->id,
            ]);
        }

        // Trattamento 4: Videosorveglianza
        $trattamento4 = Trattamento::create([
            'mandante_id' => $mandante->id,
            'nome' => 'Videosorveglianza',
            'descrizione' => 'Riprese video degli ambienti aziendali per motivi di sicurezza',
            'finalita' => 'Tutela del patrimonio aziendale, sicurezza dei lavoratori e visitatori',
            'categorie_interessati' => 'Dipendenti, visitatori, fornitori',
            'base_giuridica' => 'Art. 6(1)(f) GDPR - Legittimo interesse del titolare',
            'destinatari' => 'Forze dell\'ordine (in caso di reati), società di vigilanza',
            'trasferimenti_extra_ue' => 'Nessuno',
            'termini_conservazione' => '7 giorni (salvo necessità di conservazione per indagini)',
            'misure_sicurezza' => 'Cartellonistica informativa, accesso limitato alle registrazioni, cifratura storage',
            'is_active' => true,
        ]);

        // Trattamento 5: Selezione del Personale
        $trattamento5 = Trattamento::create([
            'mandante_id' => $mandante->id,
            'nome' => 'Selezione del Personale',
            'descrizione' => 'Raccolta e valutazione dei CV per processi di recruiting',
            'finalita' => 'Valutazione delle candidature, selezione dei candidati idonei',
            'categorie_interessati' => 'Candidati, persone in cerca di occupazione',
            'base_giuridica' => 'Art. 6(1)(b) GDPR - Esecuzione di misure precontrattuali; Art. 6(1)(a) GDPR - Consenso',
            'destinatari' => 'Agenzie di recruiting, società di head hunting',
            'trasferimenti_extra_ue' => 'Nessuno',
            'termini_conservazione' => '12 mesi dalla candidatura (salvo consenso per conservazione più lunga)',
            'misure_sicurezza' => 'Database protetto da password, accesso limitato al team HR',
            'is_active' => true,
        ]);

        if ($datiAnagrafici && $datiContatto && $datiProfessionali) {
            $trattamento5->categorieDati()->attach([
                $datiAnagrafici->id,
                $datiContatto->id,
                $datiProfessionali->id,
            ]);
        }

        $this->command->info('Creati 5 trattamenti di esempio');
    }
}
