<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type, $value)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        if ($type === 'role') {
            if (!$user->hasRole($value)) {
                abort(403, 'You do not have permission to access this page!');
            }
        } elseif ($type === 'permission') {
            if (!$user->can($value)) {
                session()->flash('error', 'You do not have permission to access this page!');
            return redirect()->back()->with('error', 'You do not have permission to access this page!');
            }
        } else {
            session()->flash('error', 'Invalid middleware parameters');
            return redirect()->back()->with('error', 'Invalid middleware parameters');
        }

        return $next($request);
    }
}
