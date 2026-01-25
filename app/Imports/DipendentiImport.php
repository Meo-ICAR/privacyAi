<?php

// app/Imports/DipendentiImport.php

namespace App\Imports;

use App\Models\Dipendente;
use App\Models\Mansioni;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DipendentiImport implements ToCollection, WithHeadingRow
{
    protected $mandante_id;

    public function __construct($mandante_id)
    {
        $this->mandante_id = $mandante_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find or create mansione
            $mansione = Mansioni::firstOrCreate(
                ['nome' => $row['mansione'] ?? 'Non specificata'],
                ['descrizione' => 'Importato automaticamente']
            );

            Dipendente::updateOrCreate(
                [
                    'codice_fiscale' => $row['codice_fiscale'],
                    'mandante_id' => $this->mandante_id
                ],
                [
                    'nome' => $row['nome'] ?? null,,
                    'cognome' => $row['cognome'] ?? null,
                    'email' => $row['email'] ?? null,
                    'mansione_id' => $mansione->id,
                    'data_assunzione' => isset($row['data_assunzione'])
                        ? Carbon::parse($row['data_assunzione'])
                        : null,
                    'albo' => $row['albo'] ?? null,
                    'data_iscrizione' => isset($row['data_iscrizione'])
                        ? Carbon::parse($row['data_iscrizione'])
                        : null,
                    'is_active' => true
                ]
            );
        }
    }
}
