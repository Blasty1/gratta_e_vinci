<?php

namespace App\Http\Controllers;

use App\Models\DeleteTobaccoShop;
use App\Models\TobaccoShop;
use App\Notifications\sendEmailToDeleteTobaccoShop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeleteTobaccoShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,int $tobaccoShop)
    {
        $user = $request->user();
        $token = \Str::random(40);

        $result = DeleteTobaccoShop::insert([
            'tobaccoShop_id' => $tobaccoShop,
            'token' => Hash::make($token),
            'expires_at' => Carbon::now()->addSeconds(\Config::get('scratchAndWinApp.MAX_MINUTES_TO_DELETE_TOBACCOSHOP') * 60)
        ]);
        $user->notify(new sendEmailToDeleteTobaccoShop(TobaccoShop::find($tobaccoShop),$token));
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeleteTobaccoShop  $deleteTobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function show(DeleteTobaccoShop $deleteTobaccoShop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeleteTobaccoShop  $deleteTobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function edit(DeleteTobaccoShop $deleteTobaccoShop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeleteTobaccoShop  $deleteTobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeleteTobaccoShop $deleteTobaccoShop)
    {
        //
    }

    /**
     * Delete tobacco Shop and all data about it.
     *
     * @param  \App\Models\DeleteTobaccoShop  $deleteTobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $tobaccoShop, string $token)
    {
        $richiesta = DeleteTobaccoShop::where('tobaccoShop_id',$tobaccoShop)->first();

        //se il token corrisponde nel database , inoltre la corrispondenza deve essere giusta e il token risulta essere ancora valido 
        if($richiesta && Hash::check($token,$richiesta->token) && Carbon::now()->diffInMinutes($richiesta->expires_at) <= \Config::get("scratchAndWinApp.MAX_MINUTES_TO_DELETE_TOBACCOSHOP"))
        {
            TobaccoShop::find($tobaccoShop)->first()->delete();
            $message = "Operazione eseguita correttamente";
        }else
        {
            $message = 'Errore, token errato oppure scaduto';
        }
        
        return view('response', [ 'message' => $message]);

    }
}
