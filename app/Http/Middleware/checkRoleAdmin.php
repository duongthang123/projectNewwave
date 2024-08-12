<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        $userRoles = $user->roles->pluck('name')->toArray();
        if($user && array_intersect($userRoles, $roles)) {
            return $next($request);
        }
        abort(403, 'Không tìm thấy trang yêu cầu!');
    }
}
