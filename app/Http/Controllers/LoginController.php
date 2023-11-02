<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\client;
use Session;

use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function index()
    {
        if (Session::has('active_user')){
            return redirect('/');
        }
        else{
            return view('auth.login');
        }
    }

    public function create()
    {
        if (Session::has('active_user')){
            return redirect('/');
        }
        else{
            $email = request('input_email');
            $password = request('input_password');
    
            if(User::where('user_email_address', $email)->exists()){
                $user = User::where('user_email_address', $email)->get();
    
                if(Hash::check($password, $user[0]->user_password)){
                    session()->put('active_user', 'true');
                    session()->put('user_id', $user[0]->user_id);
                    session()->put('first_name', $user[0]->user_first_name);
                    session()->put('last_name', $user[0]->user_last_name);
                    session()->put('email', $user[0]->user_email_address);
                    session()->put('user_type', $user[0]->user_type);
                    if(client::where('user_id', $user[0]->user_id)->exists())
                    {
                        $client = client::where('user_id', $user[0]->user_id)->get();
                        session()->put('client_id', $client[0]->client_id);
                    }
                    return redirect('/');
                };
            }
            session()->flush();
            session()->put('loginError', 'Email and Password did not match our systems, please try again.');
            return redirect('/login');
        }
    }

    public function logout(){
        session()->flush();
        return redirect('/login');
    }
}
