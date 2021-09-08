<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\TobaccoShop;
use App\Models\User;
use App\Notifications\EmployeeAdded;
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
        if( $isUserJustRegistered ) return  $isUserJustRegistered->notify(new EmployeeAdded());

        
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
        if(TobaccoShop::find($tobaccoShop)->employees($employee)) Employee::find($employee)->delete();
    }
}
