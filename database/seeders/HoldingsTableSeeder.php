<?php

namespace Database\Seeders;

use App\Models\AziendaTipo;
use App\Models\Holding;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HoldingsTableSeeder extends Seeder
{
    public function run()
    {
        $listproviders = [
            ['ragione_sociale' => 'GDS', 'p_iva' => '01477560138'],  // GDS Communication S.r.l.
            ['ragione_sociale' => 'DATITALIA', 'p_iva' => '01477560138'],  // GDS Communication S.r.l.
        ];

        $sws = [
            ['ragione_sociale' => 'INNOVATIVE', 'p_iva' => '07209440721'],  // Innovazione & Software S.r.l.
            ['ragione_sociale' => 'MEDIAFACILE', 'p_iva' => '06158600962'],  // Facile.it Mediazione Creditizia S.p.A.
            ['ragione_sociale' => 'EVA', 'p_iva' => '03699320986'],  // Eva Energia S.r.l.
            ['ragione_sociale' => 'EGG FINANCE', 'p_iva' => '02724980640'],  // Egg Finance S.p.A.
            ['ragione_sociale' => 'HASSISTO', 'p_iva' => '09006331210'],  // Hassisto S.r.l.
        ];

        $utilities = [
            ['ragione_sociale' => 'AUDAX ENERGIA', 'p_iva' => '10027190015'],
            ['ragione_sociale' => 'ENERGIA PULITA', 'p_iva' => '10802400969'],
            ['ragione_sociale' => 'FACILE', 'p_iva' => '07902950968'],  // Facile.it S.p.A.
            ['ragione_sociale' => 'HERA', 'p_iva' => '02221101203'],  // Hera Comm S.p.A.
            ['ragione_sociale' => 'ILLUMIA', 'p_iva' => '02356770988'],
            ['ragione_sociale' => 'SERVIZIO ENERGETICO', 'p_iva' => '15844561009'],  // Servizio Elettrico Nazionale (Gruppo IVA Enel)
            ['ragione_sociale' => 'TIM', 'p_iva' => '00488410010'],
            ['ragione_sociale' => 'WIND', 'p_iva' => '13378520152'],  // Wind Tre S.p.A.
            ['ragione_sociale' => 'VODAFONE', 'p_iva' => '08539010010'],
        ];

        $holdings = [
            ['ragione_sociale' => 'AGOS SPA', 'p_iva' => '08570720154'],
            ['ragione_sociale' => 'ASSICURAPOINT', 'p_iva' => '12003220014'],  // Assicura Point Broker S.r.l.
            ['ragione_sociale' => 'Banca Aidexa S.p.A.', 'p_iva' => '00691500706'],
            ['ragione_sociale' => 'BANCA CF+', 'p_iva' => '16340351002'],
            ['ragione_sociale' => 'BANCA DEL FUCINO', 'p_iva' => '01861900189'],
            ['ragione_sociale' => 'BANCA DI SCONTO SPA', 'p_iva' => '14994571009'],
            ['ragione_sociale' => 'BANCA NUOVA TERRA', 'p_iva' => '03944450968'],
            ['ragione_sociale' => 'Banca Progetto S.p.A.', 'p_iva' => '02261070136'],
            ['ragione_sociale' => 'BANCA SISTEMA SPA', 'p_iva' => '12870770158'],
            ['ragione_sociale' => 'BNL', 'p_iva' => '09339391006'],
            ['ragione_sociale' => 'BNT BANCA S.p.A.', 'p_iva' => '01086930144'],
            ['ragione_sociale' => 'CAPTIALFIN', 'p_iva' => '04570150278'],
            ['ragione_sociale' => 'COMPASS BANCA S.P.A', 'p_iva' => '10536040966'],
            ['ragione_sociale' => 'CONFESERFIDI', 'p_iva' => '01188660888'],
            ['ragione_sociale' => 'DYNAMICA', 'p_iva' => '10537880964'],
            ['ragione_sociale' => 'FBA BROKERS INSURANCE DI FARAONE VINCENZO', 'p_iva' => '07635201218'],
            ['ragione_sociale' => 'Fides S.p.A.', 'p_iva' => '10537880964'],
            ['ragione_sociale' => 'Fidimed', 'p_iva' => '00730360823'],
            ['ragione_sociale' => 'FIGENPA SPA', 'p_iva' => '03401350107'],
            ['ragione_sociale' => 'FINCONTINUO SPA', 'p_iva' => '02597720792'],
            ['ragione_sociale' => 'FINCREDITO', 'p_iva' => '14944491001'],
            ['ragione_sociale' => 'FUCINO FINANCE', 'p_iva' => '01861900189'],
            ['ragione_sociale' => 'IBL BANCA SPA', 'p_iva' => '14994571009'],
            ['ragione_sociale' => 'IFIVER', 'p_iva' => '02084220280'],
            ['ragione_sociale' => 'Mediobanca', 'p_iva' => '10536040966'],
            ['ragione_sociale' => 'PERMICRO', 'p_iva' => '09645130015'],
            ['ragione_sociale' => 'Prestiamoci S.P.A.', 'p_iva' => '09800370018'],
            ['ragione_sociale' => 'SWITCHO', 'p_iva' => '10740070965'],
            ['ragione_sociale' => 'VITANUOVA', 'p_iva' => '04352620233'],
            ['ragione_sociale' => 'VIVIBANCA SPA', 'p_iva' => '12755550014'],
            ['ragione_sociale' => 'WE FINANCE', 'p_iva' => '01654870052'],
            ['ragione_sociale' => 'YOUNITED SA', 'p_iva' => '13722821009'],
        ];
        // cerca azienda tipo

        $azienda_tipo = AziendaTipo::where('name', 'Utility')->first();
        foreach ($utilities as $utility) {
            Holding::updateOrCreate(
                ['p_iva' => $utility['p_iva']],
                ['ragione_sociale' => Str::upper($utility['ragione_sociale'])],
                ['azienda_tipo_id' => $azienda_tipo->id],
            );
        }

        $azienda_tipo = AziendaTipo::where('name', 'List Provider')->first();
        foreach ($listproviders as $listprovider) {
            Holding::updateOrCreate(
                ['p_iva' => $listprovider['p_iva']],
                ['ragione_sociale' => Str::upper($listprovider['ragione_sociale'])],
                ['azienda_tipo_id' => $azienda_tipo->id],
            );
        }

        // cerca azienda tipo
        $azienda_tipo = AziendaTipo::where('name', 'Finanziaria')->first();
        foreach ($holdings as $holding) {
            Holding::updateOrCreate(
                ['p_iva' => $holding['p_iva']],
                ['ragione_sociale' => Str::upper($holding['ragione_sociale'])],
                ['azienda_tipo_id' => $azienda_tipo->id],
            );
        }

        // cerca azienda tipo
        $azienda_tipo = AziendaTipo::where('name', 'Software')->first();
        foreach ($sws as $sw) {
            Holding::updateOrCreate(
                ['p_iva' => $sw['p_iva']],
                ['ragione_sociale' => Str::upper($sw['ragione_sociale'])],
                ['azienda_tipo_id' => $azienda_tipo->id],
            );
        }
    }
}
