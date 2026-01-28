<?php

namespace App\Filament\Components;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class LogoColumn extends SpatieMediaLibraryImageColumn
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->label('Logo')
            ->circular()
            ->getStateUsing(function ($record) {
                if ($record->hasMedia('logo')) {
                    // Try thumb first, then original
                    $thumbUrl = $record->getFirstMediaUrl('logo', 'thumb');
                    if ($thumbUrl && $thumbUrl !== '') {
                        return $thumbUrl;
                    }
                    return $record->getFirstMediaUrl('logo');
                }

                // Fallback to avatar
                $name = $record->ragione_sociale ?? $record->name ?? 'Logo';
                return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=oklch(0.141+0.005+285.823)';
            })
            ->toggleable();
    }
}
