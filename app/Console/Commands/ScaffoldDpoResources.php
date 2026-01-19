<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScaffoldDpoResources extends Command
{
    protected $signature = 'dpo:scaffold-models';
    protected $description = 'Genera Model dalle migrazioni includendo ULID e MediaLibrary';

    public function handle()
    {
        $migrationsPath = database_path('migrations');
        $files = File::files($migrationsPath);

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            if (preg_match('/Schema::create\([\'"]([^\'"]+)[\'"]/', $content, $matches)) {
                $tableName = $matches[1];

                if (in_array($tableName, ['users', 'password_reset_tokens', 'failed_jobs', 'personal_access_tokens', 'sessions', 'cache'])) {
                    continue;
                }

                $modelName = Str::studly(Str::singular($tableName));
                $this->comment("📦 Generazione Model: {$modelName}");

                // 1. Genera il modello base via Artisan
                $this->callSilent('make:model', ['name' => $modelName]);

                // 2. Modifica il file per aggiungere ULID e Spatie Media Library
                $this->injectTraits($modelName);
            }
        }

        $this->info('🚀 Modelli pronti con supporto MediaLibrary e ULID!');
    }

    protected function injectTraits($modelName)
    {
        $path = app_path("Models/{$modelName}.php");
        if (!File::exists($path))
            return;

        $content = File::get($path);

        // Prepariamo gli import
        $imports = [
            'use Illuminate\Database\Eloquent\Concerns\HasUlids;',
            'use Spatie\MediaLibrary\HasMedia;',
            'use Spatie\MediaLibrary\InteractsWithMedia;'
        ];

        // Prepariamo l'implementazione e l'uso dei trait
        $useTraits = '    use HasUlids, InteractsWithMedia;';

        // Sostituzioni nel file
        $content = str_replace(
            'use Illuminate\Database\Eloquent\Model;',
            "use Illuminate\Database\Eloquent\Model;\n" . implode("\n", $imports),
            $content
        );

        $content = str_replace(
            "class {$modelName} extends Model",
            "class {$modelName} extends Model implements HasMedia",
            $content
        );

        $content = str_replace(
            '{',
            "{\n{$useTraits}\n",
            $content
        );

        File::put($path, $content);
    }
}
