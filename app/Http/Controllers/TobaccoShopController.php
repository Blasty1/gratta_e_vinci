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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TobaccoShop  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function show(TobaccoShop $tobaccoShop)
    {
        //\Auth::logout();
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
