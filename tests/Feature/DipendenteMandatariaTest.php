<?php

namespace Tests\Feature;

use App\Models\Dipendenti;
use App\Models\Holding;
use App\Models\Mandante;
use App\Models\Mandatarie;
use App\Models\Mansioni;
use App\Models\Fornitori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;

class DipendenteMandatariaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_associate_employee_from_same_holding()
    {
        Model::unguard();

        // Create Holding
        $holding = Holding::create([
            'id' => (string) str()->ulid(),
            'ragione_sociale' => 'Holding X',
            'p_iva' => '12345678901',
        ]);

        // Create Mandante A and B in same holding
        $mandanteA = Mandante::create([
            'id' => (string) str()->ulid(),
            'ragione_sociale' => 'Mandante A',
            'p_iva' => '11111111111',
            'titolare_trattamento' => 'Titolare A',
            'email_referente' => 'admin@a.com',
            'holding_id' => $holding->id,
            'is_active' => true,
        ]);

        $mandanteB = Mandante::create([
            'id' => (string) str()->ulid(),
            'ragione_sociale' => 'Mandante B',
            'p_iva' => '22222222222',
            'titolare_trattamento' => 'Titolare B',
            'email_referente' => 'admin@b.com',
            'holding_id' => $holding->id,
            'is_active' => true,
        ]);

        // Create Fornitore for Mandante B
        $fornitore = Fornitori::create([
            'id' => (string) str()->ulid(),
            'ragione_sociale' => 'Fornitore X',
            'p_iva' => '99999999999',
            'responsabile_trattamento' => 'Admin Fornitore',
            'data_nomina' => now()->toDateString(),
            'mandante_id' => $mandanteB->id,
        ]);

        // Create Dipendente in Mandante B
        $dipendente = Dipendenti::create([
            'id' => (string) str()->ulid(),
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501U',
            'email_aziendale' => 'mario.rossi@b.com',
            'mandante_id' => $mandanteB->id,
            'fornitore_id' => $fornitore->id,
            'is_active' => true,
        ]);

        // Create Mandataria for Mandante A
        $mandataria = Mandatarie::create([
            'id' => (string) str()->ulid(),
            'mandante_id' => $mandanteA->id,
            'ragione_sociale' => 'Mandataria A1',
            'p_iva' => '33333333333',
            'titolare_trattamento' => 'Titolare M',
            'email_referente' => 'm@m.com',
            'data_ricezione_nomina' => now()->toDateString(),
        ]);

        // Create Mansione
        $mansione = Mansioni::create([
            'id' => (string) str()->ulid(),
            'nome' => 'Responsabile',
        ]);

        try {
            // Associate Dipendente (from Mandante B) to Mandataria (of Mandante A)
            $mandataria->dipendenti()->attach($dipendente->id, [
                'id' => (string) str()->ulid(),
                'mansione_id' => $mansione->id,
                'data_autorizzazione' => now()->toDateString(),
                'is_active' => true,
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            throw $e;
        }

        // Assert relationship exists
        $this->assertDatabaseHas('dipendente_mandataria', [
            'dipendente_id' => $dipendente->id,
            'mandataria_id' => $mandataria->id,
            'mansione_id' => $mansione->id,
        ]);

        $this->assertEquals(1, $mandataria->dipendenti()->count());
        $this->assertEquals($mansione->id, $mandataria->dipendenti->first()->pivot->mansione_id);

        Model::reguard();
    }
}
