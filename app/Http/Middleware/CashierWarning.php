<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CashierWarning
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;
        /*foreach($repositories as $repository){
            if($repository->isCashierWarning())
                return redirect(route('cashier.warning',$repository->id));
        }*/
        foreach($repositories as $repository){
            $warning = $repository->CashierWarningDetails();
            if($warning['status']==true)
                return redirect(route('cashier.warning',$repository->id));
        }
        return $next($request);
    }
}
