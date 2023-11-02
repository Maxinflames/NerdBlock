<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\genre;
use App\client;
use App\subscription;
use Session;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'C')
            {
                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title',
                    DB::raw('date_add(subscription.subscription_date, interval subscription.subscription_length month) as subscription_end_date')])
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->join('client', 'subscription.client_id', '=', 'client.client_id')
                    ->where('client.user_id', "=", session()->get('user_id'))
                    ->get();

                return view('subscription.index', compact('subscriptions'));
            }
            else
            {
                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title', 'client.client_id',
                DB::raw('date_add(subscription.subscription_date, interval subscription.subscription_length month) as subscription_end_date')])
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('client', 'subscription.client_id', '=', 'client.client_id')
                ->get();

                return view('subscription.index', compact('subscriptions'));
            }
        }
        return redirect('/');
    }

    // Probably not necessary, all data is shown in index
    public function show(/**Post $post**/)
    {
        if(Session::has('active_user'))
        {
            
        }
        else
        {
            return redirect('/');
        }
    }
    
    public function create(genre $genre)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'C')
            {
                return view('subscription.create', compact('genre'));
            }
        }
        return redirect('/');
    }

    public function edit(/**Post $post**/)
    {      
        if(Session::has('active_user'))
        {
            return redirect('/');
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
        $text = request('search_text');
        if($text != "" || $text != null){
            if (session()->get('user_type') == 'C')
            {
                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title',
                    DB::raw('date_add(subscription.subscription_date, interval subscription.subscription_length month) as subscription_end_date')])
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->join('client', 'subscription.client_id', '=', 'client.client_id')
                    ->where('client.user_id', "=", session()->get('user_id'))
                    ->where('subscription.subscription_id', 'like', '%' . $text . '%')
                    ->orwhere(function ($query) use ($text){
                        $query->where('client.user_id', "=", session()->get('user_id'))
                        ->where('genre.genre_title', 'like', '%' . $text . '%');
                    })
                    ->get();

                return view('subscription.index', compact('subscriptions'));
            }
            else
            {
                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title', 'client.client_id',
                DB::raw('date_add(subscription.subscription_date, interval subscription.subscription_length month) as subscription_end_date')])
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('client', 'subscription.client_id', '=', 'client.client_id')
                ->where('subscription.subscription_id', 'like', '%' . $text . '%')
                ->orwhere('genre.genre_title', 'like', '%' . $text . '%')
                ->get();

                return view('subscription.index', compact('subscriptions'));
            }

            // If the post exists that is equal to Id, redirect to the view page
            if ($subscriptions->count() != 0) {

                return view('subscription.index', compact('subscriptions'));
            }

            // Otherwise, redirect back to user index, with a server variable status initialized 
            else {
                session()->put('search_error', 'No matches found!');
            }
        }
        return redirect('/subscriptions');
    }

    public function store()
        {
            $genre_id = request('genre_id');
            $client_id = client::select(['client.client_id'])
            ->where('client.user_id', session()->get('user_id'))
            ->first();
            $subscription_length = request('subscription_length');
    
            $subscription_date = subscription::select(['subscription.subscription_date'])
            ->where('subscription.client_id', $client_id->client_id)
            ->where('subscription.genre_id', $genre_id)
            ->orderBy('subscription.subscription_id', 'desc')
            ->first();

            if(!is_null($subscription_date))
            {
                $date = Carbon::parse($subscription_date->subscription_date)->addMonths($subscription_length);
                
                if($date->isFuture())
                {
                    session()->put('SubscriptionError', 'You already have an active subscription for this genre!');
                    return redirect(('/subscriptions/create/'.$genre_id));
                }
            }
            if($subscription_length == "3"){
                $subscription_cost = 75.00;
            }
            else if($subscription_length == "6"){
                $subscription_cost = 120.00;
            }
            else{
                $subscription_cost = 180.00;
            }

            subscription::create([
                'client_id' => $client_id->client_id,
                 'genre_id' => $genre_id,
                 'subscription_date' => Carbon::today()->toDateString(),
                 'subscription_length' => $subscription_length,
                 'subscription_cost' => $subscription_cost,
                 ]);

            return redirect('/subscriptions');
        }

    public function update()
    {

    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
