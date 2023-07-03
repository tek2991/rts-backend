<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user has administrator or manager role, let them through
        if ($request->user()->hasAnyRole('administrator', 'manager')) {
            return $next($request);
        }
        // Redirect to client dashboard if user has client role
        if ($request->user()->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }
    }
}
