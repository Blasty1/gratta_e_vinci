<?php

namespace App\Traits;

use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
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
    function checkifPackageIsBeenJustRegistered($idScratchAndWin,$tokenToCheck)
    {
        return ScratchAndWinTobaccoShop::where('scratchAndWin_id',$idScratchAndWin)->where('tokenPackage' , $tokenToCheck)->where('quantity','>',0)->get()->first();
    }
    function checkifNumberOfIsBeenJustRegistered($idScratchAndWin,$tokenToCheck,$numberOfPackage)
    {
        return ScratchAndWinTobaccoShop::where('scratchAndWin_id',$idScratchAndWin)->where('tokenPackage',$tokenToCheck)->where('numberOfPackage',$numberOfPackage)->get()->first();
    }
    
}


?>