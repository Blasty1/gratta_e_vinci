<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ScratchAndWin;
use App\Models\ScratchAndWinTobaccoShop;
use App\Models\TobaccoShop;
use App\Traits\employeeHandle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScratchAndWinTobaccoShopController extends Controller
{
    use employeeHandle;
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
        $newRecord = ScratchAndWinTobaccoShop::create(
            [
                'tobaccoShop_id' => $tobaccoShop,
                'quantity' => (int) filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT),
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
        return response()->json($this->employeeAddingUserInfo(TobaccoShop::find($tobaccoShop)->scratchAndWins) );
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
