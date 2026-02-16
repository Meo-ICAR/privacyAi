<?php

namespace App\Imports;

use App\Models\Mandatarie;
use App\Models\AziendaTipo;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Filament\Actions\Imports\ImportColumn;

class MandatarieImport implements ToModel, WithHeadingRow, WithMapping
{
    protected static ?string $model = Mandatarie::class;

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
        // vengono normalizzate (es: "Ragione Sociale" -> "ragione_sociale")
        $normalizedRow = collect($row)->keyBy(function ($value, $key) {
            return Str::slug($key, '_');
        });
        
        Log::info('Dati Mandataria in Excel:', [
            'attributi' => $normalizedRow->all(),
        ]);

        // Controllo Duplicati (Ragione Sociale + P.IVA)
       // Controllo Duplicati (Ragione Sociale + P.IVA)
        $ragioneSociale = $normalizedRow->get('ragione_sociale')
            ?? $normalizedRow->get('banca_/intermediario_denominazione')
            ?? $normalizedRow->get('societa')
            ?? $normalizedRow->get('fornitore');



        $existing = Mandatarie::where('ragione_sociale', $ragioneSociale)
            ->where('mandante_id', $tenantId)
           ;

        if ($existing) {
            return null;
        }

        // Gestione Azienda Tipo
        $nomeAziendaTipo = $normalizedRow->get('aziendatipo')
            ?? $normalizedRow->get('tipo_azienda')
            ?? $normalizedRow->get('categoria');

        $aziendaTipoId = null;
        if ($nomeAziendaTipo) {
            $aziendaTipo = AziendaTipo::firstOrCreate(['nome' => $nomeAziendaTipo]);
            $aziendaTipoId = $aziendaTipo->id;
        }

    

        // Creazione Istanza Modello
        $mandataria = new Mandatarie();

        $mandataria->id = (string) Str::ulid();
        $mandataria->mandante_id = $tenantId;

        $mandataria->ragione_sociale = $ragioneSociale;
         $mandataria->fornitura_prodotti = $normalizedRow->get('fornitura_prodotti');
        /*
        $mandataria->p_iva = $partitaIva;
        $mandataria->website = $normalizedRow->get('website');
        $mandataria->landingpage = $normalizedRow->get('landingpage')
            ?? $normalizedRow->get('landing_page');
        $mandataria->titolare_trattamento = $normalizedRow->get('titolare_trattamento')
            ?? $normalizedRow->get('titolare')
            ?? $normalizedRow->get('data_controller');
        $mandataria->email_referente = $normalizedRow->get('email_referente')
            ?? $normalizedRow->get('email')
            ?? $normalizedRow->get('contatto_email');

        // Campi GDPR
        $mandataria->categorie_dati = $normalizedRow->get('categorie_dati')
            ?? $normalizedRow->get('tipologie_dati')
            ?? $normalizedRow->get('data_categories');
        $mandataria->descrizione_categorie_dati = $normalizedRow->get('descrizione_categorie_dati')
            ?? $normalizedRow->get('descrizione_dati')
            ?? $normalizedRow->get('data_description');
        $mandataria->categorie_interessati = $normalizedRow->get('categorie_interessati')
            ?? $normalizedRow->get('tipologie_interessati')
            ?? $normalizedRow->get('data_subjects');
        $mandataria->finalita_trattamento = $normalizedRow->get('finalita_trattamento')
            ?? $normalizedRow->get('finalita')
            ?? $normalizedRow->get('purposes');
        $mandataria->tipo_trattamento = $normalizedRow->get('tipo_trattamento')
            ?? $normalizedRow->get('tipo')
            ?? $normalizedRow->get('processing_type');
        $mandataria->termini_conservazione = $normalizedRow->get('termini_conservazione')
            ?? $normalizedRow->get('conservazione')
            ?? $normalizedRow->get('retention');
        $mandataria->paesi_trasferimento_dati = $normalizedRow->get('paesi_trasferimento_dati')
            ?? $normalizedRow->get('trasferimento_dati')
            ?? $normalizedRow->get('data_transfer');
        $mandataria->misure_sicurezza_tecniche = $normalizedRow->get('misure_sicurezza_tecniche')
            ?? $normalizedRow->get('sicurezza_tecnica')
            ?? $normalizedRow->get('technical_measures');
        $mandataria->misure_sicurezza_organizzative = $normalizedRow->get('misure_sicurezza_organizzative')
            ?? $normalizedRow->get('sicurezza_organizzativa')
            ?? $normalizedRow->get('organizational_measures');
        $mandataria->responsabili_esterni = $normalizedRow->get('responsabili_esterni')
            ?? $normalizedRow->get('esterni')
            ?? $normalizedRow->get('external_processors');
        $mandataria->modalita_raccolta_consenso = $normalizedRow->get('modalita_raccolta_consenso')
            ?? $normalizedRow->get('raccolta_consenso')
            ?? $normalizedRow->get('consent_collection');
        $mandataria->contitolare_trattamento = $normalizedRow->get('contitolare_trattamento')
            ?? $normalizedRow->get('contitolare')
            ?? $normalizedRow->get('joint_controller');
        $mandataria->note_gdpr = $normalizedRow->get('note_gdpr')
            ?? $normalizedRow->get('note')
            ?? $normalizedRow->get('privacy_notes');

        // Parsing date
        $mandataria->data_ricezione_nomina = $this->convertExcelDate($normalizedRow->get('data_ricezione_nomina')
            ?? $normalizedRow->get('data_nomina')
            ?? $normalizedRow->get('nomina'));

        // Gestione booleano per consenso
        $consensoField = $normalizedRow->get('richiesto_consenso')
            ?? $normalizedRow->get('consenso')
            ?? $normalizedRow->get('consent_required');
        
        $mandataria->richiesto_consenso = filter_var($consensoField, FILTER_VALIDATE_BOOLEAN);
*/
        // Assegnazione Relazioni
        $mandataria->aziendatipo_id = $aziendaTipoId;
 

        // Salva la mandataria
        $mandataria->save();

        return $mandataria;
    }

    function convertExcelDate($excelDate)
    {
        if (empty($excelDate)) {
            return null;
        }

        return Carbon::createFromDate(1899, 12, 30)
            ->addDays((int) $excelDate)
            ->format('Y-m-d');
    }

    }
