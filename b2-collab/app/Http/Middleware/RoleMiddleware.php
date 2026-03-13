<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        $userRole = $user->getRelationValue('role') ?? $user->role()->first();

        if (!$userRole) {
            abort(403, 'Accès non autorisé. Aucun rôle assigné.');
        }

        // Get the required role level
        $requiredRole = \App\Models\Role::where('name', $role)->first();

        if (!$requiredRole) {
            abort(403, 'Rôle requis introuvable.');
        }

        if ($userRole->level < $requiredRole->level) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
