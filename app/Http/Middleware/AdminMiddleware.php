<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Suport\Facades\Auth;

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
        // Verifica se l'utetente è autenticato e se è un amnistratore
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Se l'utente non è amnistratore, viene reidirizzato
        return redirect('/')->with('error', 'Accesso negato.');
    }
}
