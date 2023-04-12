<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\updateInfoUser;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|max:256',
                'name' => 'required|max:256',
                'surname' => 'required|max:256',
                'street_address' => 'required|max:256',
            ]
            );

            $user_who_did_the_request = $request->user();
            if(User::select('email')->where('id','!=',$user_who_did_the_request->id)->where('email',strip_tags($request->email))->first())
            {
                return response()->json(
                    [
                        'email' => 'Errore, email già utilizzata da un altro account'
                    ],403
                );
            }
            if($user_who_did_the_request->email != strip_tags($request->email))
            {
                $user_who_did_the_request->notify(new updateInfoUser());
                $user_who_did_the_request->email = strip_tags($request->email);
            }
            $user_who_did_the_request->name = strip_tags($request->name);
            $user_who_did_the_request->surname = strip_tags($request->surname);
            $user_who_did_the_request->street_address = strip_tags($request->street_address);

            $user_who_did_the_request->save();

            $user_who_did_the_request->notify(new updateInfoUser());

            


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
