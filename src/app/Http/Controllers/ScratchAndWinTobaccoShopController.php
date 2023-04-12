<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ScratchAndWin;
use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
use App\Traits\employeeHandle;
use App\Traits\ScratchAndWinHandler;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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

        //token del pacco del gv
        $tokenOfPackage = strip_tags(substr($request->token,4,7));

        //numero del gratta e vinci venduto
        $numberOfPackage = strip_tags(substr($request->token,11,-2));

        // se la quantità non viene specificata significa che si vuole registrare l'acquisizione di un intero pacco
        $quantity = $request->quantity ?? $this->getNumberOfScratchAndWinInAPackage($scratchAndWin);
        if(!$request->quantity && $this->checkifPackageIsBeenJustRegistered($scratchAndWin->id,$tokenOfPackage) )
        {
            return response()->json(
                [
                    'errors' => ['token' => ['Pacco già registrato']]
                ],
                404
                );
        }
        
        
        //se il numero non è presente
        if(!$numberOfPackage)
        {
            return response()->json(
                [
                    'errors' => ['token' => ['Caricamento errato del GV, riprova']]
                ],
                404
                );
        }

        //controlliamo se il numero del gratta e vinci è già stato inserito
        if($request->quantity && $this->checkifNumberOfIsBeenJustRegistered($scratchAndWin->id,$tokenOfPackage,$numberOfPackage))
        {
                return response()->json(
                    [
                        'errors' => ['token' => ['Numero del GV già registrato']]
                    ],
                    404
                );
        }

        //controlliamo se il numero del gratta e vinci è corretto e congruo
        if($request->quantity && ( ( $this->getNumberOfScratchAndWinInAPackage($scratchAndWin) - 1) < (int) $numberOfPackage  ||   (int) $numberOfPackage < 0 ) )
        {
            return response()->json(
                [
                    'errors' => ['token' => ['Numero del GV errato, riprova']]
                ],
                404
                );
        }

        $newRecord = ScratchAndWinTobaccoShop::create(
            [
                'tobaccoShop_id' => $tobaccoShop,
                'quantity' => (int) filter_var($quantity, FILTER_SANITIZE_NUMBER_INT),
                'employee_id' => $employeeOrOwner, // who has sold the item
                'scratchAndWin_id' => $scratchAndWin->id,
                'tokenPackage' => strip_tags(substr($request->token,4,7)),
                'numberOfPackage' => $request->quantity ? $numberOfPackage : '' // se registriamo il pacco non ci interessa il numero del gratta e vinci inserito
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
        return response()->json($this->employeeAddingUserInfo(TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today())->wherePivot('quantity' ,'<', 0)->orderBy('pivot_created_at')->get()) );
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
        $stats = [];
        foreach( $scratchAndWins as $key => $scratchAndWin)
        {           
            $stats[$key]['total_quantity'] = $scratchAndWin->sum('pivot.quantity');
            $stats[$key]['total_money'] = $stats[$key]['total_quantity'] * $scratchAndWin[0]->prize;
            $stats[$key]['total_money_earned'] = $stats[$key]['total_money'] * \Config::get('scratchAndWinApp.guadagno');
        }
        return $stats;
    }

    /**
     * ritorna tutti i giorni del mese
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function daily($tobaccoShop)
    {  

        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today()->month)->wherePivot('quantity' ,'<', 0)->wherePivot("created_at",">",Carbon::today()->subDays(\Config::get('scratchAndWinApp.MAX_DAY_TO_SHOW')))->get()->groupBy(function($scratchAndWin){
            return $scratchAndWin->pivot->created_at->format('d/m/Y'); // grouping by months
        
        });
        $stats = [];
        foreach( $scratchAndWins as $key => $scratchAndWinOne)
        {
            $stats[$key]['total_quantity'] = $scratchAndWinOne->sum('pivot.quantity');
            $stats[$key]['total_money'] = $this->sumForEachItems($scratchAndWinOne);
            $stats[$key]['total_money_earned'] = $stats[$key]['total_money'] * \Config::get('scratchAndWinApp.guadagno');
            
        }
        uksort($stats ,function($first_date,$second_date){
            return $this->orderByTime($first_date,$second_date);
        });
        return $stats;
    }



    /**
     * ritorna gli incassi di tutto il mese
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function monthly($tobaccoShop)
    {  
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins(Carbon::today()->year)->wherePivot('quantity' ,'<', 0)->wherePivot('created_at','>',Carbon::today()->subMonth(\Config::get('scratchAndWinApp.MAX_MONTH_TO_SHOW')))->get()->groupBy(function($scratchAndWin){
    
            return $scratchAndWin->pivot->created_at->format('m/Y'); // grouping by year and month
        
        });
        foreach( $scratchAndWins as $key => $scratchAndWinOne)
        {
            $stats[$key]['total_quantity'] = $scratchAndWinOne->sum('pivot.quantity');
            $stats[$key]['total_money'] = $this->sumForEachItems($scratchAndWinOne);
            $stats[$key]['total_money_earned'] = $stats[$key]['total_money'] * \Config::get('scratchAndWinApp.guadagno');
        }
        
        uksort($stats ,function($first_date,$second_date){
            return $this->orderByTime($first_date,$second_date);
        });
        return $stats;
    }


    /*
     * ritorna gli incassi della settimana contabile 
     *
     * @param  int  $tobaccoShop
     * @return \Illuminate\Http\Response
     */
    public function dayChoosenByUser($tobaccoShop, Request $request)
    { 
        $request->validate([
            'groupBy' => [
                Rule::in(['d', 'W','m']),
                'required'
            ],
            'start' => 'required|date',
            'finish' => 'required|date|after:start'
        ]);
        $groupBy = $request->groupBy;
        $scratchAndWins = TobaccoShop::find($tobaccoShop)->scratchAndWins()->wherePivot('quantity' ,'<', 0)
                                                                           ->wherePivot('created_at','>',Carbon::parse($request->start))
                                                                           ->wherePivot('created_at','<',Carbon::parse($request->finish)->addDay())->get()
                                                                           ->groupBy(function($scratchAndWin)use ($groupBy) {
                                                                               $dateFormatted = $scratchAndWin->pivot->created_at->format($groupBy);
                                                                               if($groupBy == 'W') return $scratchAndWin->pivot->created_at->startOfWeek()->format('d/m/Y') . ' to ' .  $scratchAndWin->pivot->created_at->endOfWeek()->format('d/m/Y') ;
                                                                               if($groupBy == 'd') return $dateFormatted . '/' . $scratchAndWin->pivot->created_at->format('m/Y') ;
                                                                               if($groupBy == 'm') return $dateFormatted . '/' . $scratchAndWin->pivot->created_at->format('Y') ;
                                                                            });

        $stast = [];
        foreach( $scratchAndWins as $key => $scratchAndWinOne)
        {
            $stats[$key]['total_quantity'] = $scratchAndWinOne->sum('pivot.quantity');
            $stats[$key]['total_money'] = $this->sumForEachItems($scratchAndWinOne);
            $stats[$key]['total_money_earned'] = $stats[$key]['total_money'] * \Config::get('scratchAndWinApp.guadagno');
        }
        uksort($stats ,function($first_date,$second_date)
        {
            return $this->orderByTime(\Str::of($first_date)->explode(' ')[0],\Str::of($second_date)->explode(' ')[0]);
        });
        return $stats;
             
        
        
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
