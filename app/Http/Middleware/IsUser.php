<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
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
        if(Auth::check() && auth()->user()->isAdmin==0 && auth()->user()->validated==1) {
            return $next($request);
        }
        if(Auth::check() && auth()->user()->validated==0){
            Auth::logout();
            return redirect('/login')->with('error_validado',1);
        }
        return redirect('/restringido');
    }
}
