<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class ApiAuthenticateMiddleware
{
    use ApiResponse;

    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $next($request);
            }
        }
        return $this->errorResponse(['error' => 'unAuthenticated'], 401);
    }

}
