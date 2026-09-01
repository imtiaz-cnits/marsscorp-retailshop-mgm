<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
   
public function handle(Request $request, Closure $next): Response
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    return redirect('/nexus-login-page')->with('alert', 'Access denied. Admins only.');
}

}
