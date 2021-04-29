<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
       /* if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            $user = User::find($user->id);
            if($user->hasRole('مشرف'))
            return redirect(RouteServiceProvider::HOME);
            elseif($user->hasRole('مالك-مخزن'))
            return redirect('/sales');
        }
        return $next($request);*/
    }
}
