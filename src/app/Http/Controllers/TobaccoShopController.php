<?php

namespace App\Http\Controllers;

use App\Models\TobaccoShop;
use Illuminate\Http\Request;

class TobaccoShopController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:256|',
            'street_address' => 'required|max:256'
        ]);

        $newTobacco = TobaccoShop::create([
            'name' => strip_tags($request->name),
            'street_address' => strip_tags($request->street_address),
            'user_id' => $request->user()->id,
            'token' => \Str::random(10)
        ]);

        return $newTobacco;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TobaccoShop  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function show(TobaccoShop $tobaccoShop)
    {

        return view('contabilità', [
            'user'  => \Auth::user(),
            'tobaccoShop' => $tobaccoShop
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TobaccoShop  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function edit(TobaccoShop $tobaccoShop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TobaccoShop  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TobaccoShop $tobaccoShop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TobaccoShop  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(TobaccoShop $tobaccoShop)
    {
        //
    }
}
