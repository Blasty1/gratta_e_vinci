<?php

namespace App\Http\Middleware;

use App\Models\TobaccoShop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $idUser=\Auth::id() ?? $request->user()->id;
        if( is_numeric($request->tobaccoShop) )
        {
             $owner = TobaccoShop::find($request->tobaccoShop);
             
        }else{

            $owner = $request->tobaccoShop;

        }

        if( $owner->id != $idUser && !$owner->employees($idUser)) return redirect()->route('dashboard');
        return $next($request);
    }
}
