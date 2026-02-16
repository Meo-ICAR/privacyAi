<?php

echo "--- Verifica Driver Grafici ---\n";

$extensions = ['gd', 'imagick'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "[OK] Estensione '$ext' è CARICATA.\n";
    } else {
        echo "[!!] Estensione '$ext' NON è presente.\n";
    }
}

echo "\n--- Verifica Funzioni Specifiche ---\n";

if (function_exists('imagecreatefromstring')) {
    echo "[OK] Funzione 'imagecreatefromstring' disponibile.\n";
} else {
    echo "[ERRORE] Funzione 'imagecreatefromstring' NON trovata. GD non funziona correttamente.\n";
}

echo "\n--- Verifica Permessi Percorso Spatie ---\n";

$path = '/var/www/html/privacyAi/storage/media-library/temp/';
if (is_writable($path)) {
    echo "[OK] La cartella temp è SCRIVIBILE.\n";
} else {
    echo "[ERRORE] La cartella temp NON è scrivibile o non esiste.\n";
    echo "Percorso: $path\n";
}
