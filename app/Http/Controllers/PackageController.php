<?php

namespace App\Http\Controllers;

use App\Models\TobaccoShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
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
     * Display packages didn't sell
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idTobaccoShop)
    {
        $scratchAndWinsTokens = TobaccoShop::find($idTobaccoShop)->scratchAndWins->groupBy(['token','pivot.tokenPackage'] );
        $scratchAndWinsInSelling = [];
        foreach($scratchAndWinsTokens as $scratchAndWinsToken)
        {
            foreach($scratchAndWinsToken as $scratchAndWinToken)
            {

                $numberOfItemInPackageTotale = config('scratchAndWinApp.valore_pacco') / $scratchAndWinToken[0]->prize;
                $numberOfItemInPackageAvaiable = $scratchAndWinToken->sum('pivot.quantity');
                
                if($numberOfItemInPackageAvaiable > 0)
                {
                    $numbersAvaiable = range(0, $numberOfItemInPackageTotale - 1);
                    foreach($scratchAndWinToken as $scratchAndWin)
                    {
                        if(in_array($scratchAndWin->pivot->numberOfPackage,$numbersAvaiable))
                        {
                            $positionOfElement = array_search($scratchAndWin->pivot->numberOfPackage,$numbersAvaiable);
                            unset($numbersAvaiable[$positionOfElement]);
                        }
                    }
                    $scratchAndWinsInSelling[] = [
                        'name' => $scratchAndWinToken[0]->name,
                        'itemsInSelling' => $numberOfItemInPackageAvaiable,
                        'numbersOfPackageNotSold' => $numbersAvaiable,
                        'tokenPackage' => $scratchAndWinToken[0]->pivot->tokenPackage,
                        'created_at' => $scratchAndWinToken->where('pivot.quantity','>',0)->first()->pivot->created_at
                    ]; 
                }
            }
        }
        return response()->json($scratchAndWinsInSelling);

    }


    public function showPackageSold($idTobaccoShop)
    {
        $scratchAndWinsTokens = TobaccoShop::find($idTobaccoShop)->scratchAndWins->groupBy(['token','pivot.tokenPackage'] );
        $scratchAndWinsInSelling = [];
        foreach($scratchAndWinsTokens as $scratchAndWinsToken)
        {
            foreach($scratchAndWinsToken as $scratchAndWinToken)
            {
            
                $numberOfItemInPackageAvaiable = $scratchAndWinToken->sum('pivot.quantity');
                
                if($numberOfItemInPackageAvaiable == 0)
                {
                    $scratchAndWinsInSelling[] = [
                        'name' => $scratchAndWinToken[0]->name,
                        'tokenPackage' => $scratchAndWinToken[0]->pivot->tokenPackage,
                        'created_at' => $scratchAndWinToken->where('pivot.quantity','>',0)->first()->pivot->created_at,
                        'updated_at' => $scratchAndWinToken->sortByDesc('pivot.created_at')->first()->pivot->created_at,
                    ]; 
                }
            }
        }
        return response()->json($scratchAndWinsInSelling);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
