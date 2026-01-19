<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScaffoldDpoFilament extends Command
{
    protected $signature = 'dpo:scaffold-filament';
    protected $description = 'Genera le Filament Resource seguendo le migrazioni e integra Spatie Media Library';

    public function handle()
    {
        $migrationsPath = database_path('migrations');
        $files = File::files($migrationsPath);

        $this->info('🚀 Inizio generazione risorse Filament con supporto MediaLibrary...');

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            if (preg_match('/Schema::create\([\'"]([^\'"]+)[\'"]/', $content, $matches)) {
                $tableName = $matches[1];

                if (in_array($tableName, ['users', 'password_reset_tokens', 'failed_jobs', 'personal_access_tokens', 'sessions', 'cache', 'media'])) {
                    continue;
                }

                $modelName = Str::studly(Str::singular($tableName));

                $this->comment("🖥️  Generazione Risorsa Filament per: {$modelName}");

                // Generazione della risorsa
                $this->call('make:filament-resource', [
                    'name' => $modelName,
                    '--generate' => true,
                    '--view' => true,
                ]);

                // Iniezione automatica campi MediaLibrary
                $this->injectMediaField($modelName, $content);
            }
        }

        $this->info("\n✨ Scaffold completato! Ricorda di configurare le collection nei Model.");
    }

    protected function injectMediaField($modelName, $migrationContent)
    {
        $resourcePath = app_path("Filament/Resources/{$modelName}Resource.php");
        if (!File::exists($resourcePath))
            return;

        $content = File::get($resourcePath);

        // Verifichiamo se nella migrazione ci sono campi che suggeriscono un file
        // Ad esempio: logo, allegato, documento, contratto, file
        if (preg_match('/(logo|allegato|documento|contratto|file|immagine)/i', $migrationContent, $matches)) {
            $fieldName = $matches[1];
            $this->info("📎 Rilevato potenziale campo media: {$fieldName}. Iniezione componente...");

            // 1. Aggiungiamo l'import in alto se manca
            if (!str_contains($content, 'SpatieMediaLibraryFileUpload')) {
                $content = str_replace(
                    'use Filament\Forms\Components\TextInput;',
                    "use Filament\Forms\Components\TextInput;\nuse Filament\Forms\Components\SpatieMediaLibraryFileUpload;",
                    $content
                );
            }

            // 2. Inseriamo il componente nel metodo form() prima della fine dello schema
            // Cerchiamo di posizionarlo dopo i campi esistenti
            $mediaComponent = "\n                SpatieMediaLibraryFileUpload::make('{$fieldName}')\n                    ->collection('{$fieldName}')\n                    ->downloadable()\n                    ->openable()\n                    ->reorderable(),";

            // Lo inseriamo prima della chiusura dell'array dello schema
            $content = preg_replace('/(\s+\])\s+(\);)/', $mediaComponent . '$1$2', $content);

            File::put($resourcePath, $content);
        }
    }
}
