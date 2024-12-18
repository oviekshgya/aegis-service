<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $username = 'gamecloud';  // Ganti dengan username custom
        $password = 'shagya51';  // Ganti dengan password custom

        // Cek apakah header Authorization ada dan valid
        if (!$request->hasHeader('Authorization')) {
            return response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        // Ambil nilai Authorization header
        $authHeader = $request->header('Authorization');
        if (substr($authHeader, 0, 6) !== 'Basic ') {
            return response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        // Decode username dan password
        $credentials = base64_decode(substr($authHeader, 6));
        list($inputUsername, $inputPassword) = explode(':', $credentials);

        // Cek username dan password
        if ($inputUsername !== $username || $inputPassword !== $password) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
