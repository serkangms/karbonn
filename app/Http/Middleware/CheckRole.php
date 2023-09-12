<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = auth()->user()->role;
        if (!auth()->check()) {
            return redirect('/login');
        }
        $roles = array_slice(func_get_args(), 2);

        if (!in_array($userRole, $roles)) {
            abort(403, 'Bu sayfayı görüntüleme yetkiniz yok.');
        }
        return $next($request);
    }
}
