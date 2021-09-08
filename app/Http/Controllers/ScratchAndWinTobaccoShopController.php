<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ScratchAndWin;
use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
use App\Traits\employeeHandle;
use App\Traits\ScratchAndWinHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScratchAndWinTobaccoShopController extends Controller
{
    use employeeHandle , ScratchAndWinHandler;
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
    public function store(Request $request, $tobaccoShop)
    {
        $employeeOrOwner = TobaccoShop::find($tobaccoShop)->employees($request->user()->id)->first()  ? Employee::where('user_id',$request->user()->id )->where('tobaccoShop_id',$tobaccoShop)->get()->first()->id : null;
        $scratchAndWin = ScratchAndWin::where('token',strip_tags(substr($request->token,0,4)))->get()->first();
        $userEmployeeInfo  = $employeeOrOwner ? $request->user() : null;
        if( !$scratchAndWin ) return response()->json([
            'errors' => [ 'token' => [ 'Gratta e Vinci non trovato' ] ]
         ],404);
        // se la quantità non viene specificata significa che si vuole registrare l'acquisizione di un intero pacco
        $quantity = $request->quantity ?? $this->getNumberOfScratchAndWinInAPackage($scratchAndWin);
        if(!$request->quantity && $this->checkfPackageIsBeenJustRegistered(strip_tags(substr($request->token,4,7))) ) return ;
        $newRecord = ScratchAndWinTobaccoShop::create(
            [
                'tobaccoShop_id' => $tobaccoShop,
                'quantity' => (int) filter_var($quantity, FILTER_SANITIZE_NUMBER_INT),
                'employee_id' => $employeeOrOwner, // who has sold the item
                'scratchAndWin_id' => $scratchAndWin->id,
                'tokenPackage' => strip_tags(substr($request->token,4,7)),
                'numberOfPackage' => strip_tags(substr($request->token,12,-2))
            ]
        );
        return response()->json(array_merge($scratchAndWin->toArray() , array_merge([ 'pivot' => $newRecord ], ['user' => $userEmployeeInfo])));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tobaccoShop)
    {
        return response()->json($this->employeeAddingUserInfo(TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today())->wherePivot('quantity' ,'<', 0)->get()) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Return the list of items sold in this day
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function today($tobaccoShop)
    {
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today())->wherePivot('quantity' ,'<', 0)->get()->groupBy('name');
        foreach( $scratchAndWins as $scratchAndWin)
        {           
            $scratchAndWin['total_quantity'] = $scratchAndWin->sum('pivot.quantity');
            $scratchAndWin['total_money'] = $scratchAndWin['total_quantity'] * $scratchAndWin[0]->prize;
            $scratchAndWin['total_money_earned'] = $scratchAndWin['total_money'] * \Config::get('scratchAndWinApp.guadagno');
        }
        return $scratchAndWins;
    }

    /**
     * ritorna tutti i giorni del mese
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function daily($tobaccoShop)
    {  
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today()->month)->wherePivot('quantity' ,'<', 0)->get()->groupBy(function($scratchAndWin){
            return $scratchAndWin->pivot->created_at->format('d/m/Y'); // grouping by months
        
        });
        foreach( $scratchAndWins as $key => $scratchAndWinOne)
        {
            $scratchAndWinOne['total_quantity'] = $scratchAndWinOne->sum('pivot.quantity');
            $scratchAndWinOne['total_money'] = $this->sumForEachItems($scratchAndWinOne);
            $scratchAndWinOne['total_money_earned'] = $scratchAndWinOne['total_money'] * \Config::get('scratchAndWinApp.guadagno');
            
            
        }
        function orderByDate($first_date,$second_date)
        {
                $first_date = Carbon::createFromFormat('d/m/Y',$first_date);
                $second_date = Carbon::createFromFormat('d/m/Y',$second_date);
                if ($first_date == $second_date) return ($r = 0);
                $r = ($first_date > $second_date) ? -1: 1;
                return $r;
        }
        $ordered = $scratchAndWins->toArray();
        uksort($ordered ,function($first_date,$second_date){
            return orderByDate($first_date,$second_date);
        });
        return $ordered;
    }



    /**
     * ritorna gli incassi di tutto il mese
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function monthly($tobaccoShop)
    {  
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today()->year)->wherePivot('quantity' ,'<', 0)->get()->groupBy(function($scratchAndWin){
            return $scratchAndWin->pivot->created_at->format('m/Y'); // grouping by year
        
        });
        foreach( $scratchAndWins as $key => $scratchAndWinOne)
        {
            $scratchAndWinOne['total_quantity'] = $scratchAndWinOne->sum('pivot.quantity');
            $scratchAndWinOne['total_money'] = $this->sumForEachItems($scratchAndWinOne);
            $scratchAndWinOne['total_money_earned'] = $scratchAndWinOne['total_money'] * \Config::get('scratchAndWinApp.guadagno');
        }
        $ordered = $scratchAndWins->toArray();
        function orderByTime($first_date,$second_date)
        {
                $first_date = Carbon::createFromFormat('m/Y',$first_date);
                $second_date = Carbon::createFromFormat('m/Y',$second_date);
                if ($first_date == $second_date) return ($r = 0);
                $r = ($first_date > $second_date) ? -1: 1;
                return $r;
        }
        uksort($ordered ,function($first_date,$second_date){
            return orderByTime($first_date,$second_date);
        });
        return $ordered;
    }
     /**
     * Return all packages bought
     *
     */
    public function packages($tobaccoShop)
    {
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins()->wherePivot('quantity','>',0)->orderBy('pivot_created_at')->get();
        return $scratchAndWins;
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
    public function destroy($tobaccoShop,$scratchAndWinTobaccoShop)
    {
        $recordToDelete = ScratchAndWinTobaccoShop::find($scratchAndWinTobaccoShop);
        if($recordToDelete->tobaccoShop_id != $tobaccoShop) return response()->json("Errore , hai tentato di eliminare un record non appartenente alla tua attività", 402);
        $recordToDelete->delete();
    }
}
