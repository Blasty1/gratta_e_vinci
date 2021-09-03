<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ownerOrEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $idUser=\Auth::id() ;
        if( $request->tobaccoShop->owner->id != $idUser && !$request->tobaccoShop->employees($idUser)) return redirect()->route('dashboard');
        return $next($request);
    }
}
