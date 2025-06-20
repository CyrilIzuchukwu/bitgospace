<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For GET requests, check the query parameter
        if ($request->isMethod('get')) {
            if (!$request->has('ref')) {
                return redirect('/')->with('error', 'Registration requires a valid referral link');
            }

            $ref = $request->query('ref');
            $referrer = User::where('referral_link', 'like', "%{$ref}%")->first();

            if (!$referrer) {
                return redirect('/')->with('error', 'Invalid referral link');
            }

            // Store in session for POST request
            session(['referrer' => $referrer->id]);
            return $next($request);
        }

        // For POST requests, check the session
        if (!session()->has('referrer')) {
            return redirect('/')->with('error', 'Referral session expired');
        }

        return $next($request);
    }
}
