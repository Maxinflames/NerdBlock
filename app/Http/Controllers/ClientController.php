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
            if (session()->get('user_type') == 'A')
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

    public function show(user $user )
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {          
                if($user->user_id != null){
                    $user_data = user::select(['user.user_id', 'user.user_first_name', 'user.user_last_name', 'user.user_email_address', 'user.user_type', 
                    'client.client_id', 'client.client_country', 'client.client_region', 'client.client_city', 'client.client_address', 
                    'client.client_region_post_code', 'client.client_country_code', 'client.client_telephone'])
                    ->leftjoin('client', 'user.user_id', '=', 'client.user_id')
                    ->where('user.user_id', '=', $user->user_id)
                    ->get();
                    return view('user.show', compact('user_data'));
                }  
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
            if (session()->get('user_type') == 'A')
            {           
                return view('user.index', compact('user'));
            }
        }
        return redirect('/');
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

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
            'user_email_address' =>'required|string|email|unique:user|max:255',
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

    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
