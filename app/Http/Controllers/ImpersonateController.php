<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function impersonate(User $user)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        // Solo il super_admin può impersonare
        if (!$currentUser->hasRole('super_admin')) {
            abort(403);
        }

        // Salva l'ID dell'utente originale nella sessione
        session()->put('impersonated_by', $currentUser->id);

        Auth::login($user);

        return redirect('/admin');
    }

    public function stopImpersonating()
    {
        if (!session()->has('impersonated_by')) {
            return redirect('/admin');
        }

        $originalUserId = session()->pull('impersonated_by');
        $originalUser = User::find($originalUserId);

        if ($originalUser) {
            Auth::login($originalUser);
        }

        return redirect('/admin/mandantis');
    }
}
