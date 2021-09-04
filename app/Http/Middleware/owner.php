<?php

namespace App\Http\Middleware;

use App\Models\TobaccoShop;
use Closure;
use Illuminate\Http\Request;

class owner
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
        if( TobaccoShop::find($request->tobaccoShop)->owner->id !== $request->user()->id) return response()->json('Non puoi effettuare questa modifica',404);
        return $next($request);
    }
}
