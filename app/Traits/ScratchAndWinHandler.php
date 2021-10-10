<?php

namespace App\Traits;

use App\Models\ScratchAndWinTobaccoShop;
use Illuminate\Support\Facades\Log;

trait ScratchAndWinHandler{

    // serve a calcolare i soldi per ogni bviglietto venduto
    function sumForEachItems($scratchAndWinsSold)
    {
        $sumToReturn = 0;
        foreach($scratchAndWinsSold as $scratchAndWinOne )
        {
            if(is_int($scratchAndWinOne)) continue;
            $sumToReturn += $scratchAndWinOne->prize;
        }
        return $sumToReturn;
    }
    function getNumberOfScratchAndWinInAPackage($scratchAndWin)
    {
        return round(\Config::get('scratchAndWinApp.valore_pacco') / $scratchAndWin->prize);
    }
    function checkfPackageIsBeenJustRegistered($tokenToCheck)
    {
        return ScratchAndWinTobaccoShop::where('tokenPackage' , $tokenToCheck)->get()->first();
    }
    function getAllPackagesNotSold()
    {
        $allScratchAndWinSold = ScratchAndWinTobaccoShop::all()->groupBy('tokenPackage');

    }
}


?>