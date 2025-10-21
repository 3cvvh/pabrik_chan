<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class Beatrice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->pabrik_id == null){
                return redirect()->route('guest.index');
            }
            if(Auth::user()->role_id == 4){
                return redirect()->route('super.index');
            }elseif(Auth::user()->role_id == 1){
                return redirect()->route('admin.index');
            }
            elseif(Auth::user()->role_id == 2){
                return redirect()->route('orang_gudang.index');
            }
            elseif(Auth::user()->role_id == 3){
                return redirect()->route('owner.index');
            }
        }

        return $next($request);
    }
}
