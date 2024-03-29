<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
class LoginGoogleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Socialite::with('google')->stateless()->redirect()->getTargetUrl();
    }

    /**
     * logout user
     *
     * @return \Illuminate\Http\Response
     */
    public function closeSession()
    {
        Auth::logout();
        return redirect(RouteServiceProvider::HOME);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user  = Socialite::driver('google')->stateless()->user()->user;

        $user_found = User::where('email',strip_tags($user['email']))->get()->first();
        if(!$user_found)
        { 
            $user_found = User::create([
                'name' => strip_tags($user['given_name']),
                'email' => strip_tags($user['email']),
                'password' => \Hash::make(\Str::random(8)),
                'surname' => strip_tags($user['family_name']),
                'street_address' => strip_tags($user['locale'])
            ]);

            event(new Registered($user_found));
            $token = EmployeeToken::where('email',$user_found->email)->get()->first();
            if ( $token ) 
            {
                Employee::create([
                    'user_id' => $user_found->id,
                    'tobaccoShop_id' => $token->tobaccoShop_id,
                ]);
                $token->delete();
            }
            $user_found->notify( new \App\Notifications\Registered());

        }

        \Auth::login($user_found,true);
        
        return redirect()->guest(route('dashboard'));
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
    public function destroy($id)
    {
        //
    }
}
