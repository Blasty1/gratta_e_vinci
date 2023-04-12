<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeToken;
use App\Models\TobaccoShop;
use App\Models\User;
use App\Notifications\EmployeeAdded;
use App\Notifications\TokenSendForEmployee;
use App\Traits\employeeHandle;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
    public function store($tobaccoShop, Request $request)
    {
        $tobaccoShop = TobaccoShop::find($tobaccoShop);
        $request->validate([
            'email' => 'email|required'
        ]);

        $isUserJustRegistered = User::where('email',strip_tags(htmlentities($request->email)))->get()->first();
        
        if( $isUserJustRegistered )
        { 

            if( count($tobaccoShop->employees($isUserJustRegistered->id)) ) 
            { 
                    return response()->json([
                        'errors' => [ 'email' => [ 'Utente già vostro dipendente' ] ]
                    ],402);
            }

            $isUserJustRegistered->notify(new EmployeeAdded($tobaccoShop));
            Employee::create([
                'user_id' => $isUserJustRegistered->id,
                'tobaccoShop_id' => $tobaccoShop->id,
                
            ]);
        }else
        {
            if( EmployeeToken::where('email',strip_tags(htmlentities($request->email)))->get()->first() ) 
            {
                return response()->json([
                    'errors' => [ 'email' => [ 'Utente già invitato' ] ]
                ],402);
            }
            $token = EmployeeToken::create([
                'token' => \Str::random(20),
                'email' => strip_tags(htmlentities($request->email)),
                'tobaccoShop_id' => $tobaccoShop->id
            ]);

            $token->notify( new TokenSendForEmployee($tobaccoShop));




        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($tobaccoShop)
    {
        $employees = TobaccoShop::find($tobaccoShop)->employees()->orderBy('pivot_created_at')->get();
        foreach( $employees as $employee )
        {
            $employee['scratchAndWinSold'] = $this->getScratchAndWinSoldByEmployee($employee);
        }
        return $employees;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($tobaccoShop,$employee)
    {
        if(TobaccoShop::find($tobaccoShop)->employees($employee)) Employee::where('user_id',$employee)->delete();
    }
}
