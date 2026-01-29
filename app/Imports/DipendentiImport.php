<?php

namespace App\Imports;

use App\Models\Dipendente;
use App\Models\Filiali;  // Assumo che il model della filiale si chiami Sede
use App\Models\Mansioni;  // Assumo che il model della filiale si chiami Sede
use App\Models\Mandatarie;
use App\Models\Corso;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class DipendentiImport implements ToModel, WithHeadingRow, WithMapping
{
    protected static ?string $model = Dipendente::class;

    public function map($row): array
    {
        return collect($row)->keyBy(function ($value, $key) {
            // Converte in minuscolo e trasforma spazi/trattini in underscore
            return strtolower(str_replace([' ', '-'], '_', $key));
        })->toArray();
    }

    public function model(array $row)
    {
        $tenantId = Filament::getTenant()->id;
        // Creiamo un array pulito dove le chiavi del file Excel
        // vengono normalizzate (es: "Prezzo Vendita" -> "prezzo_vendita")
        $normalizedRow = collect($row)->keyBy(function ($value, $key) {
            return Str::slug($key, '_');
        });
        Log::info('Dati Dipendente in Excel:', [
            'attributi' => $normalizedRow->all(),  // <--- USA all() oppure toArray()
        ]);

        /*
         * NOEMI
         * {"attributi":{"impiegato":"ANATRIELLO VALENTINA","codice_fiscale":"NTRVNT92P59A512W","luogo_di_nascita":"AVERSA","data_di_nascita":33866,"sede":"AVERSA","tipoctr":"cococo","inizioctr":45356,"fine_ctr":46054,"mansione":"OPERATORE"}}
         */

        /*  RACES

        */

        // 2. Controllo Duplicati (Logica tua: Nome + Cognome)
        // Recuperiamo i dati grezzi per fare il controllo
        $nome = $normalizedRow->get('nome');
        $cognome = $normalizedRow->get('cognome')
             ?? $normalizedRow->get('nominativi_dipendenti_/collaboratori')
             ?? $normalizedRow->get('nominativo')
            ?? $normalizedRow->get('impiegato');

        $existing = Dipendente::where('nome', $nome)
            ->where('cognome', $cognome)
            ->where('mandante_id', $tenantId)  // Importante: controlla solo nel tenant corrente!
            ->first();

        if ($existing) {
            // Se esiste già, restituisci null per saltare la riga
            return null;
        }

        // 3. Gestione Filiale (Lookup o Creazione)
        $nomeSede = $normalizedRow->get('filiale')
            ?? $normalizedRow->get('sede')
             ?? $normalizedRow->get('sede_lavorativa')
            ?? $normalizedRow->get('citta');

        $sedeId = null;
        if ($nomeSede) {
            $sede = Filiali::firstOrCreate(
                ['nome' => $nomeSede, 'mandante_id' => $tenantId],
                ['citta' => $nomeSede, 'indirizzo' => 'Da completare']
            );
            $sedeId = $sede->id;
        }

        // 4. Gestione Mansione/Ruolo (Lookup o Creazione)
        $nomeMansione = $normalizedRow->get('mansione')
            ?? $normalizedRow->get('ufficio')
            ?? $normalizedRow->get('tipo');

        $roleId = null;
        if ($nomeMansione) {
            // Nota: Role solitamente non ha mandante_id se usi Spatie Permission standard,
            // ma se è multitenant, aggiungi il campo necessario.
            $role = Mansioni::firstOrCreate(['nome' => $nomeMansione], ['descrizione' => $nomeMansione]);
            $roleId = $role->id;
        }

        // 5. Gestione Mandatarie (valori separati da "-")
        $mandatarieIds = [];
        $mandatarieField = $normalizedRow->get('mandataria')
            ?? $normalizedRow->get('mandatarie')
             ?? $normalizedRow->get('mandanti_con_le_quali_sono_censiti');

        if ($mandatarieField) {
            // Dividi il campo per "-" e rimuovi spazi vuoti
            $mandatarieNames = array_map('trim', explode('-', $mandatarieField));
            
            foreach ($mandatarieNames as $mandatariaName) {
                if (!empty($mandatariaName) && !in_array(strtoupper($mandatariaName), ['NESSUN', 'NESSUNO', 'NESSUNA'])) {
                    // Cerca o crea la mandataria
                    $mandataria = Mandatarie::firstOrCreate(
                        [
                            'ragione_sociale' => $mandatariaName,
                            'mandante_id' => $tenantId
                        ],
                        [
                          //  'p_iva' => 'TEMP-' . Str::upper(Str::random(8)),
                          //  'email_referente' => 'da-completare@example.com',
                        ]
                    );
                    $mandatarieIds[] = $mandataria->id;
                }
            }
        }
   $corsiIds = [];
        $corsiNames = $normalizedRow->get('corsi_di_formazione')
            ?? $normalizedRow->get('corsi_di_aggiornamento')
             ?? $normalizedRow->get('corsi_di_aggiornamento/formazione')
             ?? $normalizedRow->get('corsi_di_formazione');
              foreach ($corsiNames as $corsiName) {
                if (!empty($corsiName) || !str_starts_with($corsiName, 'NESSUN')    || !str_starts_with($corsiName, 'NESSUNO') || !str_starts_with($corsiName, 'NESSUNA')) {
                    // Cerca o crea la mandataria
                    $corsi = Corso::firstOrCreate(
                        [   
                            'titolo' => $corsiName,
                            'mandante_id' => $tenantId
                        ],
                        [
                          //  'p_iva' => 'TEMP-' . Str::upper(Str::random(8)),
                          //  'email_referente' => 'da-completare@example.com',
                        ]
                    );
                    $corsiIds[] = $corsi->id;
                }
            }
      

        // 6. Creazione Istanza Modello (NON un array)
        $dipendente = new Dipendente();

        // Assegnazione manuale dei campi
        $dipendente->id = (string) Str::ulid();
        $dipendente->mandante_id = $tenantId;
        $dipendente->is_active = true;

        $dipendente->nome = $nome;
        $dipendente->cognome = $cognome;
        $dipendente->email_aziendale = $normalizedRow->get('email');

        $dipendente->codice_fiscale = $normalizedRow->get('codice_fiscale')
            ?? $normalizedRow->get('cf');

        // Parsing date (semplificato, assicurati che il formato excel sia leggibile)
        $dipendente->data_assunzione = $this->convertExcelDate($normalizedRow->get('data_assunzione')
            ?? $normalizedRow->get('inizioctr'));

        $dipendente->data_dimissioni = $this->convertExcelDate($normalizedRow->get('data_dimissioni')
            ?? $normalizedRow->get('fine_ctr'));

        $dipendente->data_iscrizione = $this->convertExcelDate($normalizedRow->get('data_iscrizione')
            ?? $normalizedRow->get('iscrizione'));

        $dipendente->albo = $normalizedRow->get('albo')
            ?? $normalizedRow->get('onam');
        // Assegnazione Relazioni
        $dipendente->filiale_id = $sedeId;
        $dipendente->mansione_id = $roleId;

        // 7. Salva il dipendente prima di creare le relazioni
        $dipendente->save();

        // 8. Crea le relazioni con le mandatarie
        if (!empty($mandatarieIds)) {
            foreach ($mandatarieIds as $mandatariaId) {
                $dipendente->mandatarie()->attach($mandatariaId, [
                    'mansione_id' => $roleId,
                    'data_autorizzazione' => now(),
                    'is_active' => true,
                ]);
            }
        }

          // 9. Crea le relazioni con i corsi
        if (!empty($corsiIds)) {
            foreach ($corsiIds as $corsiId) {
                $dipendente->corsi()->attach($corsiId, [
                    'mansione_id' => $roleId,
              
                ]);
            }
        }

        // 9. Ritorna l'oggetto
        // Se usi "ToModel" di Laravel Excel, LUI farà il save().
        // Ma abbiamo già fatto il save() per gestire le relazioni many-to-many
        return $dipendente;
    }

    /*
     * nome	varchar(255)
     * cognome	varchar(255)
     * codice_fiscale	varchar(255)	Dato PII - Criptato a riposo ex Art. 32 GDPR
     * email_aziendale	varchar(255) NULL	Email per comunicazioni e notifiche scadenze corsi
     * mansione_id	char(26) NULL
     * data_assunzione	date NULL
     * albo	varchar(255) NULL	Albo/Ordine di appartenenza
     * data_iscrizione	date NULL	Data di iscrizione all'albo
     * data_dimissioni	date NULL
     * is_active	tinyint(1) [1]	Stato del dipendente nell'organico attivo
     * mandante_id	char(26)
     * filiale_id
     */

    function convertExcelDate($excelDate)
    {
        // Verifica se il valore è nullo, stringa vuota o zero
        if (empty($excelDate)) {
            return null;
        }

        return Carbon::createFromDate(1899, 12, 30)
            ->addDays((int) $excelDate)  // Cast a int per sicurezza
            ->format('Y-m-d');
    }

    public static function getColumns(): array
    {
        return [
            // CAMPI STANDARD
            ImportColumn::make('nome')
                ->label('Nome')
                //  ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->guess(['first_name', 'name']),
            ImportColumn::make('cognome')
                ->label('Cognome')
                //  ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->guess(['last_name', 'surname']),
            ImportColumn::make('data_assunzione')
                ->label('Assunto il')
                //  ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->guess(['data assunzione', 'assunto il']),
            ImportColumn::make('data_dimissione')
                ->label('Dimesso il')
                //  ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->guess(['data dimissione', 'dimesso il']),
            ImportColumn::make('email')
                ->label('Email (Univoco)')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('codice_fiscale')
                ->label('Codice Fiscale')
                ->rules(['max:16'])
                ->guess(['cf', 'fiscale', 'tax_code']),
            // GESTIONE FILIALE/SEDE (Non mappata direttamente a DB, ma processata dopo)
            ImportColumn::make('nome_sede_excel')
                ->label('Nome Filiale/Sede')
                ->guess(['sede', 'filiale', 'ufficio', 'location']),
            // GESTIONE FILIALE/SEDE (Non mappata direttamente a DB, ma processata dopo)
            ImportColumn::make('mansione_excel')
                ->label('Mansione')
                ->guess(['mansione', 'ufficio', 'tipo']),
            // GESTIONE MANDATARIE (valori separati da "-")
            ImportColumn::make('mandatarie_excel')
                ->label('Mandatarie (separate da -)')
                ->guess(['mandataria', 'mandatarie', 'societa', 'company']),
        ];
    }
}
