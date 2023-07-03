<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedClientHasSubscription
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
        
        // If user has no subscription, redirect to subscription page
        if (!$request->user()->hasSubscription()) {
            return redirect()->route('client.subscription.expired');
        }

        return $next($request);
    }
}
