<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as Auths;

class not_paid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auths::user()->pabrik->Ispaid == false){
            if(Auths::getUser()->role_id == 1){
                return redirect()->route('admin.index')->with('gagal',"harap berlanganan terlebih dahulu");
            }elseif(Auths::getUser()->role_id == 2){
                return redirect()->route('orang_gudang.index')->with('gagal','harap berlanganan terlebih dahulu');
            }else{
                return redirect()->route('owner.dash')->with('gagal','harap berlanganan terlebih dahulu');
            }
        }
        return $next($request);
    }
}
