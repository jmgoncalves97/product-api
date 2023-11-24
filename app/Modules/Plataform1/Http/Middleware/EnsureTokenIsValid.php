<?php

namespace App\Modules\Plataform1\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if ($token == env('PLATAFORM1_TOKEN')) {
            return $next($request);
        }

        return response()->json(['error' => 'Token invalido'], 401);
    }
}
