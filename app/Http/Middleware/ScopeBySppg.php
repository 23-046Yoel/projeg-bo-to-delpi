<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeBySppg
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            if (auth()->user()->sppg_id) {
                // Shared view data for current SPPG context
                \Illuminate\Support\Facades\View::share('current_sppg', auth()->user()->sppg);
            }
        }

        return $next($request);
    }
}
