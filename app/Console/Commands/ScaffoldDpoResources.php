<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScaffoldDpoResources extends Command
{
    // Signature aggiornata
    protected $signature = 'dpo:scaffold-resources';
    protected $description = 'Genera Model (con fillable/casts) e Resource Filament leggendo le migrazioni';

    public function handle()
    {
        $migrationsPath = database_path('migrations');
        $files = File::files($migrationsPath);

        $this->info('🚀 Inizio generazione DPO Cloud Resources...');

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            if (preg_match('/Schema::create\([\'"]([^\'"]+)[\'"]/', $content, $matches)) {
                $tableName = $matches[1];

                // Salta tabelle di sistema
                if (in_array($tableName, ['users', 'job', 'password_reset_tokens', 'failed_jobs', 'personal_access_tokens', 'sessions', 'cache', 'media', 'jobs'])) {
                    continue;
                }

                $modelName = Str::studly(Str::singular($tableName));
                $fields = $this->extractFields($content);

                $this->comment("📦 Elaborazione: {$modelName}");

                // 1. Crea/Sovrascrivi il Model con i campi reali
                $this->createModel($modelName, $fields);

                // 2. Genera la Filament Resource

                // In Laravel, per passare l'argomento principale (il nome del modello)
                // si usa la chiave 'name' solo se definita così, ma Filament lo aspetta come primo argomento.
                $this->info("🖥️  Generazione Filament Resource: {$modelName}");
                // 2. Genera la Resource Filament
                // Usiamo --model per forzare il percorso del modello ed evitare il prompt interattivo
                $this->info("🖥️  Esecuzione: php artisan make:filament-resource {$modelName} --generate --view");

                // Usiamo l'opzione -n (non-interactive) di Laravel
                $command = "php artisan make:filament-resource {$modelName} --generate --view -n";
                shell_exec($command);

                // 3. Iniezione campo MediaLibrary se necessario
                $this->injectMediaField($modelName, $content);
            }
        }

        $this->info('✅ Scaffold completato con successo!');
    }

    protected function extractFields($content)
    {
        preg_match_all('/\$table->[a-zA-Z]+\([\'"]([a-zA-Z0-9_]+)[\'"]/', $content, $matches);
        return array_diff($matches[1], ['id', 'created_at', 'updated_at', 'deleted_at']);
    }

    protected function createModel($modelName, $fields)
    {
        $path = app_path("Models/{$modelName}.php");
        $fillable = implode("\n        ", array_map(fn($f) => "'$f',", $fields));

        $casts = '';
        foreach ($fields as $field) {
            if (Str::contains($field, ['json', 'payload', 'options', 'data', 'config'])) {
                $casts .= "'$field' => 'array',\n        ";
            }
        }

        $template = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\Concerns\HasUlids;\nuse Spatie\MediaLibrary\HasMedia;\nuse Spatie\MediaLibrary\InteractsWithMedia;\nclass {$modelName} extends Model implements HasMedia\n{\n    use HasUlids, InteractsWithMedia;\n\n    protected \$fillable = [\n        {$fillable}\n    ];\n\n    protected \$casts = [\n        {$casts}    ];\n}";
        File::put($path, $template);
    }

    protected function injectMediaField($modelName, $migrationContent)
    {
        $resourcePath = app_path("Filament/Resources/{$modelName}Resource.php");
        if (!File::exists($resourcePath))
            return;

        if (preg_match('/(logo|allegato|documento|contratto|file|immagine|avatar)/i', $migrationContent, $matches)) {
            $fieldName = $matches[1];
            $content = File::get($resourcePath);

            if (!str_contains($content, 'SpatieMediaLibraryFileUpload')) {
                $content = str_replace(
                    'use Filament\Forms\Components\TextInput;',
                    "use Filament\Forms\Components\TextInput;\nuse Filament\Forms\Components\SpatieMediaLibraryFileUpload;",
                    $content
                );

                $mediaComponent = "\n                SpatieMediaLibraryFileUpload::make('{$fieldName}')\n                    ->collection('{$fieldName}')\n                    ->downloadable(),";

                $content = preg_replace('/(\s+\])\s+(\);)/', $mediaComponent . '$1$2', $content);
                File::put($resourcePath, $content);
            }
        }
    }
}
