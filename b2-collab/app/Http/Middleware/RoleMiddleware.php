<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $ranks = [
            'user' => 1,
            'moderator' => 2,
            'admin' => 3,
            'superadmin' => 4,
        ];

        $userRole = $user->role ?? 'user';

        if (!isset($ranks[$role])) {
            abort(403, 'Role requis introuvable.');
        }

        if (($ranks[$userRole] ?? 0) < $ranks[$role]) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
