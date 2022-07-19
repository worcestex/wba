<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;





class IsAdmin
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

        $guards = empty($guards) ? [null] : $guards;




        foreach ($guards as $guard) {
            //If admin
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->business_member){
                    return $next($request);

                }


            }
        }
        return redirect(RouteServiceProvider::HOME);




    }
}
