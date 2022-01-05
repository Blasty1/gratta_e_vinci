<?php

namespace App\Http\Controllers;

use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
use App\Traits\ScratchAndWinHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    use ScratchAndWinHandler;
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

                $numberOfItemInPackageTotale =$this->getNumberOfScratchAndWinInAPackage($scratchAndWinToken[0]);
                $numberOfItemInPackageAvaiable = $scratchAndWinToken->sum('pivot.quantity');
                
                $numbersAvaiable = range(0, (int)($numberOfItemInPackageTotale - 1));

                if($numberOfItemInPackageAvaiable > 0)
                {
                    foreach($scratchAndWinToken as $scratchAndWin)
                    {
                        //se il numero è appunto un numero nel database e se non è nullo allora lo converto e lo elimino dalla serie di numeri che ho per capire quelli ancora disponibili all vendita
                        if(!is_numeric($scratchAndWin->pivot->numberOfPackage))
                        {
                            continue;
                        }
                        $numberOfPackage = (int) $scratchAndWin->pivot->numberOfPackage;
                    
                        
                        if(in_array($numberOfPackage,$numbersAvaiable))
                        {
                            $positionOfElement = array_search($numberOfPackage,$numbersAvaiable);
                            unset($numbersAvaiable[$positionOfElement]);
                        }
                    }
                    //pacco registrato di gv comprati ( quindi con quantità positiva mentre quelli venduti hanno quantità negativa)
                    $packageRegistered = $scratchAndWinToken->where('pivot.quantity','>',0)->first();
                    $scratchAndWinsInSelling[] = [
                        'name' => $scratchAndWinToken[0]->name,
                        'itemsInSelling' => $numberOfItemInPackageAvaiable,
                        'numbersOfPackageNotSold' => $numbersAvaiable,
                        'tokenPackage' => $scratchAndWinToken[0]->pivot->tokenPackage, //token identificativo per ottenere il pacco di gv che ci interessa
                        'created_at' => $packageRegistered->pivot->created_at,
                        'idPackage' => $packageRegistered->pivot->id //id a livello di programmazione utile per eliminare l'intero pacco se l'utente necessita
                    ];
                }
            }
        }
        $keys = array_column($scratchAndWinsInSelling, 'itemsInSelling');
        array_multisort($keys, SORT_ASC, $scratchAndWinsInSelling);

        return response()->json($scratchAndWinsInSelling);


    }


    public function showPackageSold($idTobaccoShop)
    {
        $scratchAndWinsTokens = TobaccoShop::find($idTobaccoShop)->scratchAndWins->groupBy(['token','pivot.tokenPackage'] );
        $scratchAndWinsSold = [];
        foreach($scratchAndWinsTokens as $scratchAndWinsToken)
        {
            foreach($scratchAndWinsToken as $scratchAndWinToken)
            {
            
                $numberOfItemInPackageAvaiable = $scratchAndWinToken->sum('pivot.quantity');
                
                if($numberOfItemInPackageAvaiable == 0)
                {
                    $scratchAndWinsSold[] = [
                        'name' => $scratchAndWinToken[0]->name,
                        'tokenPackage' => $scratchAndWinToken[0]->pivot->tokenPackage,
                        'created_at' => $scratchAndWinToken->where('pivot.quantity','>',0)->first()->pivot->created_at,
                        'updated_at' => $scratchAndWinToken->sortByDesc('pivot.created_at')->first()->pivot->created_at,
                    ]; 
                }
            }
        }
        $keys = array_column($scratchAndWinsSold, 'updated_at');
        array_multisort($keys, SORT_DESC, $scratchAndWinsSold);
            return response()->json($scratchAndWinsSold);

        
        return response()->json($scratchAndWinsSold);
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
    public function destroy($idTobaccoShop,$package)
    {
        return ScratchAndWinTobaccoShop::destroy($package);
    }
}
