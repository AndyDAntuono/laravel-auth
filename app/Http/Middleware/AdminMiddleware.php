<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware: verificando autenticazione...');

        // Controllo se l'utente è autenticato
        if (!Auth::check()) {
            Log::info('AdminMiddleware: utente non autenticato, reindirizzo a /login');
            return redirect()->route('login')->with('error', 'Devi effettuare il login per accedere.');
        }

        // Controllo se l'utente è un amministratore
        if (!Auth::user()->is_admin) {
            Log::info('AdminMiddleware: utente non amministratore, reindirizzo a /');
            return redirect()->route('dashboard')->with('error', 'Accesso negato.'); // Usa un nome di rotta se possibile
        }

        Log::info('AdminMiddleware: utente amministratore, consentito l\'accesso.');
        return $next($request);
    }
}
