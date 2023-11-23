<?php

namespace App\Http\Controllers;

use App\client;
use App\User;
use Session;

use Illuminate\Http\Request;

// Highly likely all events involving clients will be handled through other controllers
class ClientController extends Controller
{

    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
            {
                $users = user::select(['user.user_id', 'user.user_first_name', 'user.user_last_name', 'user.user_email_address', 'user.user_type', 
                'client.client_id', 'client.client_country', 'client.client_region', 'client.client_city', 'client.client_address', 
                'client.client_region_post_code', 'client.client_country_code', 'client.client_telephone'])
                ->leftjoin('client', 'user.user_id', '=', 'client.user_id')
                ->get();
                return view('user.index', compact('users'));
            }
        }
        return redirect('/');
    }

    public function show(user $user)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' || session()->get('user_id') == $user->user_id)
            {
                $client = client::select(['client.*'])
                ->where('client.user_id', $user->user_id)
                ->first();

                return view('user.show', compact('user', 'client'));
            }
        }
        return redirect('/');
    }

    // While this is in Client Controller, it will actually be used to create Admin and Employee accounts, which means not user
    public function create()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {           
                return view('user.create');
            }
        }
        return redirect('/');
    }

    public function edit(user $user)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_id') == $user->user_id)
            {
                if($user->user_id == 1)
                {
                    return redirect('/users');
                }

                $client = client::select(['client.*'])
                ->where('client.user_id', $user->user_id)
                ->first();

                return view('user.edit', compact('user', 'client'));
            }
            else if (session()->get('user_type') == 'E')
            {
                return redirect('/users');
            }
        }
        return redirect('/');
    }

    public function search()
    {
        // Takes given id, 
        $id = request('id');

        // If the post exists that is equal to Id, redirect to the view page
        if (User::where('user_id', "=", $id)->exists()) {
            return redirect('/users/'.$id);
        }
        else if($id == null){
            return redirect('/users');
        }
        // Otherwise, redirect back to user index, with a server variable status initialized 
        else {
            return redirect('/users')->with('search_error', 'User not found!');
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'user_first_name' => 'required|string|max:50',
            'user_last_name' => 'required|string|max:50',
            'user_email_address' =>'required|string|email|max:255',
            'user_password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            'user_type' =>  ['regex:/^(A|E)$/']
        ]);        

        User::create([
            'user_first_name' => request('user_first_name'),
            'user_last_name' => request('user_last_name'),
            'user_email_address' => request('user_email_address'),
            'user_password' => bcrypt(request('user_password')),
            'user_type' => request('user_type'),
        ]);
        
        return redirect('/users');
    }

    public function update()
    {
        $client_id = client::select('client_id')
        ->where('user_id', '=', session()->get('user_id'))
        ->first();

        if($client_id == null)
        {
            if(request('client_id') != null)
            {
                $this->validate(request(), [
                    'user_id' => 'required|exists:user,user_id',
                    'client_id' => 'required|exists:client,client_id',
                    'user_first_name' => 'required|string|max:50',
                    'user_last_name' => 'required|string|max:50',
                    'user_email_address' =>'required|string|email|max:255',
                    'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
                    'client_country' => 'required|string|min:4|max:255',
                    'client_region' => 'required|string|max:50',
                    'client_city' => 'required|string|max:255',
                    'client_address' => 'required|string|max:255',
                    'client_region_post_code' => 'required|string|max:50',
                    'client_country_code' => 'required|string|max:10',
                    'client_telephone' => ['regex:/^(\([0-9]{3}\) [0-9]{3}-[0-9]{4})$/'],
                ]);

                if(request('user_password') == "" || request('user_password') == null)
                {
                    User::where('user_id', request('user_id'))->update([
                        'user_first_name' => request('user_first_name'),
                        'user_last_name' => request('user_last_name'),
                        'user_email_address' => request('user_email_address'),
                    ]);
            
                    Client::where('client_id', request('client_id'))->update([
                        'client_country' => request('client_country'),
                        'client_region' => request('client_region'),
                        'client_city' => request('client_city'),
                        'client_address' => request('client_address'),
                        'client_region_post_code' => request('client_region_post_code'),
                        'client_country_code' => request('client_country_code'),
                        'client_telephone' => request('client_telephone'),
                    ]);
                }
                else
                {
                    User::where('user_id', request('user_id'))->update([
                        'user_first_name' => request('user_first_name'),
                        'user_last_name' => request('user_last_name'),
                        'user_email_address' => request('user_email_address'),
                        'user_password' => bcrypt(request('user_password')),
                    ]);
            
                    Client::where('client_id', request('client_id'))->update([
                        'client_country' => request('client_country'),
                        'client_region' => request('client_region'),
                        'client_city' => request('client_city'),
                        'client_address' => request('client_address'),
                        'client_region_post_code' => request('client_region_post_code'),
                        'client_country_code' => request('client_country_code'),
                        'client_telephone' => request('client_telephone'),
                    ]);
                }
            }
            else
            {
                $this->validate(request(), [
                    'user_id' => 'required|exists:user,user_id',
                    'user_first_name' => 'required|string|max:50',
                    'user_last_name' => 'required|string|max:50',
                    'user_email_address' =>'required|string|email|unique:user|max:255',
                    'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
                ]);

                if(request('user_password') == "" || request('user_password') == null)
                {
                    User::where('user_id', request('user_id'))->update([
                        'user_first_name' => request('user_first_name'),
                        'user_last_name' => request('user_last_name'),
                        'user_email_address' => request('user_email_address'),
                        'user_type' => request('user_type'),
                    ]);
                }
                else
                {
                    User::where('user_id', request('user_id'))->update([
                        'user_first_name' => request('user_first_name'),
                        'user_last_name' => request('user_last_name'),
                        'user_email_address' => request('user_email_address'),
                        'user_password' => bcrypt(request('user_password')),
                        'user_type' => request('user_type'),
                    ]);
                }
            }
        }
        else
        {
            $this->validate(request(), [
                'user_first_name' => 'required|string|max:50',
                'user_last_name' => 'required|string|max:50',
                'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
                'client_country' => 'required|string|min:4|max:255',
                'client_region' => 'required|string|max:50',
                'client_city' => 'required|string|max:255',
                'client_address' => 'required|string|max:255',
                'client_region_post_code' => 'required|string|max:50',
                'client_country_code' => 'required|string|max:10',
                'client_telephone' => ['regex:/^(\([0-9]{3}\) [0-9]{3}-[0-9]{4})$/'],
            ]);

            if(request('user_password') == "" || request('user_password') == null)
            {
                User::where('user_id', session()->get('user_id'))->update([
                    'user_first_name' => request('user_first_name'),
                    'user_last_name' => request('user_last_name'),
                ]);
        
                Client::where('client_id', $client_id->client_id)->update([
                    'client_country' => request('client_country'),
                    'client_region' => request('client_region'),
                    'client_city' => request('client_city'),
                    'client_address' => request('client_address'),
                    'client_region_post_code' => request('client_region_post_code'),
                    'client_country_code' => request('client_country_code'),
                    'client_telephone' => request('client_telephone'),
                ]);
            }
            else
            {
                User::where('user_id', session()->get('user_id'))->update([
                    'user_first_name' => request('user_first_name'),
                    'user_last_name' => request('user_last_name'),
                    'user_password' => bcrypt(request('user_password')),
                ]);
        
                Client::where('client_id', $client_id->client_id)->update([
                    'client_country' => request('client_country'),
                    'client_region' => request('client_region'),
                    'client_city' => request('client_city'),
                    'client_address' => request('client_address'),
                    'client_region_post_code' => request('client_region_post_code'),
                    'client_country_code' => request('client_country_code'),
                    'client_telephone' => request('client_telephone'),
                ]);
            }
            return redirect('/users/'.session()->get('user_id'));
        }
        return redirect('/users');
    }
}
