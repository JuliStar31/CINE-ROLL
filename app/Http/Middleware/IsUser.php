<?php
// app/Http/Middleware/IsUser.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini khusus untuk user.');
        }

        return $next($request);
    }
}
