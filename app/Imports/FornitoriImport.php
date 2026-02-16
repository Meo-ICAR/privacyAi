<?php

namespace App\Imports;

use App\Models\Fornitori;
use App\Models\AziendaTipo;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Filament\Actions\Imports\ImportColumn;

class FornitoriImport implements ToModel, WithHeadingRow, WithMapping
{
    protected static ?string $model = Fornitori::class;

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
        
        Log::info('Dati Fornitore in Excel:', [
            'attributi' => $normalizedRow->all(),
        ]);

        // Controllo Duplicati (Ragione Sociale + P.IVA)
        $ragioneSociale = $normalizedRow->get('ragione_sociale')
            ?? $normalizedRow->get('banca_/intermediario_denominazione')
            ?? $normalizedRow->get('societa')
            ?? $normalizedRow->get('fornitore');

      

        $existing = Mandatarie::where('ragione_sociale', $ragioneSociale)
            ->where('mandante_id', $tenantId)
            ->first();

        if ($existing) {
            return null;
        }

        
        // Gestione Azienda Tipo
        $nomeAziendaTipo = 'Finanziaria';
        /*
        $normalizedRow->get('aziendatipo')
            ?? $normalizedRow->get('tipo_azienda')
            ?? $normalizedRow->get('categoria');
        */

        $aziendaTipoId = null;
        if ($nomeAziendaTipo) {
            $aziendaTipo = AziendaTipo::firstOrCreate(['name' => $nomeAziendaTipo]);
            $aziendaTipoId = $aziendaTipo->id;
        }

       

        // Creazione Istanza Modello
        $fornitore = new Fornitor();

        $fornitore->id = (string) Str::ulid();
        $fornitore->mandante_id = $tenantId;

        $fornitore->ragione_sociale = $ragioneSociale;

        /*
                $fornitore->p_iva =  $normalizedRow->get('p_iva');
        $fornitore->website = $normalizedRow->get('website');
        $fornitore->responsabile_trattamento = $normalizedRow->get('responsabile_trattamento')
            ?? $normalizedRow->get('responsabile')
            ?? $normalizedRow->get('referente');
        */
        $fornitore->fornitura_prodotti = $normalizedRow->get('fornitura_prodotti')
            ?? $normalizedRow->get('servizi')
            ?? $normalizedRow->get('prodotti')
            ?? $normalizedRow->get('prodotti_intermediati');
        /*
        $fornitore->email_referente = $normalizedRow->get('email_referente')
            ?? $normalizedRow->get('email')
            ?? $normalizedRow->get('contatto_email');
       
        $fornitore->note_compliance = $normalizedRow->get('note_compliance')
            ?? $normalizedRow->get('note')
            ?? $normalizedRow->get('annotazioni');

        // Parsing date
        $fornitore->data_nomina = $this->convertExcelDate($normalizedRow->get('data_nomina')
            ?? $normalizedRow->get('data_inizio')
            ?? $normalizedRow->get('nomina'));

        $fornitore->data_iscrizione = $this->convertExcelDate($normalizedRow->get('data_iscrizione')
            ?? $normalizedRow->get('iscrizione'));

        $fornitore->albo = $normalizedRow->get('albo')
            ?? $normalizedRow->get('numero_albo');

        // Assegnazione Relazioni
        $fornitore->mansione_id = $mansioneId;
        $fornitore->aziendatipo_id = $aziendaTipoId;
        $fornitore->holding_id = $holdingId;

        // Salva il fornitore prima di creare le relazioni
         */
        $fornitore->save();

        // Crea le relazioni con le mandatarie
        /*
        if (!empty($mandatarieIds)) {
            foreach ($mandatarieIds as $mandatariaId) {
                $fornitore->mandatarie()->attach($mandatariaId, [
                    'data_invio_accettazione' => now(),
                    'esito' => 'pending',
                    'annotazioni' => 'Importato da Excel',
                ]);
            }
        }
        */
        return $fornitore;
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
