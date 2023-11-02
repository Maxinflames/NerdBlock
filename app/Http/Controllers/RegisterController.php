<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function index()
    {
        if (Session::has('active_user')){
            return redirect('/');
        }
        else{
            return view('auth.register');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create()
    {        
        $this->validate(request(), [
            'user_first_name' => 'required|string|max:50',
            'user_last_name' => 'required|string|max:50',
            'user_email_address' =>'required|string|email|unique:user|max:255',
            'user_password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            'client_country' => 'required|string|min:4|max:255',
            'client_region' => 'required|string|max:50',
            'client_city' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_region_post_code' => 'required|string|max:50',
            'client_country_code' => 'required|string|max:10',
            'client_telephone' => ['regex:/^(\([0-9]{3}\) [0-9]{3}-[0-9]{4})$/'],
        ]);
        //^(\([0-9]{3}\) [0-9]{3}-[0-9]{4})$|^([0-9]{3} [0-9]{3} [0-9]{4})$|^([0-9]{3} [0-9]{3}-[0-9]{4})$
        // Could develop this regex to accept some other forms, and mutate the data ourselves to fit our standard
        // Could also make database of countries, their regions, and country codes... 
        // But all that is a bunch of extra work I dont want to do at the moment

        $userId = User::insertGetId([
            'user_first_name' => request('user_first_name'),
            'user_last_name' => request('user_last_name'),
            'user_email_address' => request('user_email_address'),
            'user_password' => bcrypt(request('user_password')),
            'user_type' => 'C',
        ]);

        $user = User::where('user_id', $userId)->get();

        $clientId = Client::insertGetId([
            'user_id' => $user[0]->user_id,
            'client_country' => request('client_country'),
            'client_region' => request('client_region'),
            'client_city' => request('client_city'),
            'client_address' => request('client_address'),
            'client_region_post_code' => request('client_region_post_code'),
            'client_country_code' => request('client_country_code'),
            'client_telephone' => request('client_telephone'),
        ]);

        session()->put('active_user', 'true');
        session()->put('user_id', $user[0]->user_id);
        session()->put('first_name', $user[0]->user_first_name);
        session()->put('last_name', $user[0]->user_last_name);
        session()->put('email', $user[0]->user_email_address);
        session()->put('user_type', $user[0]->user_type);
        session()->put('client_id', $clientId);

        return redirect('/');
    }
}
