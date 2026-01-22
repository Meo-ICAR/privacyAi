<?php

namespace App\Console\Commands;

use App\Models\CanaleEmail;
use App\Models\InboundEmail;
use Illuminate\Console\Command;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Log;
use Webklex\PHPIMAP\Client;

class FetchEmails extends Command
{
    protected $signature = 'mail:fetch-all';
    protected $description = 'Scarica le email per tutti i canali configurati';

    public function handle()
    {
        // Cicliamo su tutti i canali attivi
        $canali = CanaleEmail::with('provider')->get();

        foreach ($canali as $canale) {
            $this->info("Processando canale: {$canale->email} ({$canale->provider->name})");

            try {
                $this->fetchForCanale($canale);
                $canale->update(['ultimo_check' => now()]);
            } catch (\Exception $e) {
                $this->error("Errore su {$canale->email}: ".$e->getMessage());
                Log::error("Mail fetch error {$canale->id}: ".$e->getMessage());
            }
        }
    }

    protected function fetchForCanale(CanaleEmail $canale)
    {
        // 1. Configurazione Dinamica
        // Costruiamo la config array per Webklex al volo basandoci sul DB
        $config = [
            'host' => $canale->provider->host,
            'port' => $canale->provider->port,
            'encryption' => $canale->provider->encryption,
            'validate_cert' => $canale->provider->validate_cert,
            'username' => $canale->email,
            'password' => $canale->password, // Qui è già decriptata dal Cast del model
            'protocol' => 'imap',
        ];

        // 2. Connessione
        $client = new Client($config);
        $client->connect();

        // 3. Selezione Cartella
        $folder = $client->getFolder($canale->cartella_fetch);

        // 4. Fetch messaggi non letti (o dall'ultimo check)
        // Nota: webklex permette query complesse. Qui prendiamo le UNSEEN.
        $messages = $folder->query()->unseen()->limit(10)->get();

        foreach ($messages as $message) {

            // Controllo duplicati tramite Message-ID header
            $messageId = $message->getMessageId(); // <abc@server.com>

            if (InboundEmail::where('canale_email_id', $canale->id)
                ->where('message_id', $messageId)->exists()) {
                continue;
            }

            // 5. Salvataggio Database
            $emailModel = InboundEmail::create([
                'canale_email_id' => $canale->id,
                'message_id' => $messageId,
                'subject' => $message->getSubject(),
                'from_email' => $message->getFrom()[0]->mail,
                'from_name' => $message->getFrom()[0]->personal,
                'body_text' => $message->getTextBody(),
                'body_html' => $message->getHTMLBody(),
                'received_at' => $message->getDate(),
                'is_read' => false,
            ]);

            $this->info("Importata: ".$message->getSubject());

            // 6. Gestione Allegati con Spatie Media Library
            if ($message->hasAttachments()) {
                foreach ($message->getAttachments() as $attachment) {
                    // Creiamo un file temporaneo per passarlo a Spatie
                    $tempPath = tempnam(sys_get_temp_dir(), 'mail_att_');
                    file_put_contents($tempPath, $attachment->content);

                    $emailModel->addMedia($tempPath)
                        ->usingFileName($attachment->name ?? 'allegato')
                        ->usingName($attachment->name ?? 'allegato')
                        ->withCustomProperties(['mime' => $attachment->mime])
                        ->toMediaCollection('attachments');
                }
            }

            // Opzionale: Segna come letta sul server remoto
            // $message->setFlag('Seen');
        }

        $client->disconnect();
    }
}
