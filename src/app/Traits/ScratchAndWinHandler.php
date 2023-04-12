<?php

namespace App\Traits;

use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
use Carbon\Carbon;
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
        if( $scratchAndWin->prize <= 3)
        {
            return \Config::get('scratchAndWinApp.valore_pacco_1_2_3') / $scratchAndWin->prize;
        }
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
    public function orderByTime($first_date,$second_date)
    {
        try{
            $first_date =Carbon::createFromFormat('d/m/Y',$first_date);
            $second_date = Carbon::createFromFormat('d/m/Y',$second_date);
        }catch(\Exception $e)
        {
            $first_date = Carbon::createFromFormat('m/Y',$first_date);
            $second_date = Carbon::createFromFormat('m/Y',$second_date);
        }
            if ($first_date == $second_date) return ($r = 0);
            $r = ($first_date > $second_date) ? -1: 1;
            return $r;
    }
    
}


?>