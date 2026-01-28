<?php
// app/Models/Concerns/HasLogo.php

namespace App\Models\Concerns;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

trait HasLogo
{
    use InteractsWithMedia;

    /**
     * Register the logo media collection.
     * This method will be called by the model's registerMediaCollections method.
     */
    protected function registerLogoMediaCollection(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile()
            ->useFallbackUrl(asset('images/placeholder-logo.png'))
            ->useFallbackPath(public_path('images/placeholder-logo.png'))
            ->registerMediaConversions(function (Media $media) {
                \Log::info('Generating conversions for media: ' . $media->id);

                $this
                    ->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100)
                    ->sharpen(10)
                    ->format('jpg')
                    ->quality(80)
                    ->performOnCollections('logo')
                    ->nonQueued();  // Generate immediately
                $this
                    ->addMediaConversion('small')
                    ->width(50)
                    ->height(50)
                    ->sharpen(10)
                    ->format('jpg')
                    ->quality(80);

                $this
                    ->addMediaConversion('medium')
                    ->width(200)
                    ->height(200)
                    ->sharpen(10)
                    ->format('jpg')
                    ->quality(85);
            });
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrl(string $conversion = 'thumb'): string
    {
        return $this->getFirstMediaUrl('logo', $conversion);
    }

    /**
     * Check if the model has a logo.
     */
    public function hasLogo(): bool
    {
        return $this->hasMedia('logo');
    }

    /**
     * Get the logo media item.
     */
    public function getLogoMedia(): ?Media
    {
        return $this->getFirstMedia('logo');
    }
}
