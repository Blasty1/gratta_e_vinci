<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'street_address' => ['required','string','max:255',]
        ]);



        $user = User::create([
            'name' => strip_tags($request->name),
            'email' => strip_tags($request->email),
            'password' => Hash::make($request->password),
            'surname' => strip_tags($request->surname),
            'street_address' => strip_tags($request->street_address)
        ]);
        if ( $request->has('token') )
        {
            $tokenFound = EmployeeToken::where('token',strip_tags($request->token))->where('email' , $user->email)->get()->first();
            if( $tokenFound )
            {
                Employee::create([
                    'user_id' => $user->id,
                    'tobaccoShop_id' => $tokenFound->tobaccoShop_id
                ]);
                $tokenFound->delete()

            }
        }

        event(new Registered($user));
        
        Auth::login($user);

        $user->notify( new \App\Notifications\Registered());
        return redirect(RouteServiceProvider::HOME);
    }
}
