<?php

namespace App\Observers;

use App\Models\Dipendente;

class DipendenteObserver
{
    /**
     * Handle the Dipendente "created" event.
     */
    public function created(Dipendente $dipendente): void
    {
        //
    }

    /**
     * Handle the Dipendente "updated" event.
     */
    public function updated(Dipendente $dipendente): void
    {
        //
    }

    /**
     * Handle the Dipendente "deleted" event.
     */
    public function deleted(Dipendente $dipendente): void
    {
        //
    }

    /**
     * Handle the Dipendente "restored" event.
     */
    public function restored(Dipendente $dipendente): void
    {
        //
    }

    /**
     * Handle the Dipendente "force deleted" event.
     */
    public function forceDeleted(Dipendente $dipendente): void
    {
        //
    }
}
