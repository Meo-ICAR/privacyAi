<?php

namespace Database\Seeders;

use App\Models\CanaliEmail;
use App\Models\EmailProvider;
use App\Models\Mandante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class CanaleEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::all();
        $provider = EmailProvider::first();

        foreach ($mandanti as $mandante) {
            if ($provider) {
                CanaliEmail::create([
                    'mandante_id' => $mandante->id,
                    'email_provider_id' => $provider->id,
                    'label' => 'Privacy Support ' . $mandante->ragione_sociale,
                    'username' => 'privacy@' . parse_url($mandante->website, PHP_URL_HOST),
                    'password' => 'secret-password', // Sarà criptata se il modello ha i cast, altrimenti vedi migration
                ]);
            }
        }
    }
}
