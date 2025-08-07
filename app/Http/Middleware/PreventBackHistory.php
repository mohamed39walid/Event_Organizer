<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}