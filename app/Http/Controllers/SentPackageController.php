<?php

namespace App\Http\Controllers;
    
use Illuminate\Support\Facades\DB;

use App\sent_package;
use App\subscription;
use App\genre;
use App\package;
use App\product;
use App\packaged_item;

use Illuminate\Support\Str;
use Carbon\Carbon;

use Session;

use Illuminate\Http\Request;

class SentPackageController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $subscribed_genres = subscription::select(['genre_id'])
                ->join('client', 'subscription.client_id', '=', 'client.client_id')
                ->get();

                $genres = genre::wherein('genre_id', $subscribed_genres)
                ->groupBy('genre_id')
                ->get();

                $package_count = subscription::select(['subscription.subscription_id', 'subscription.subscription_length'])
                ->leftjoin('sent_package', 'subscription.subscription_id', '=', 'sent_package.subscription_id')
                ->havingRaw('count(sent_package.subscription_id) > subscription.subscription_length')
                ->groupby('subscription_id')
                ->get();

                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title', 'client.client_id', 
                DB::raw('date_add(subscription.subscription_date, interval subscription.subscription_length month) as subscription_end_date')])
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('client', 'subscription.client_id', '=', 'client.client_id')
                ->leftjoin('sent_package', 'subscription.subscription_id', '=', 'sent_package.subscription_id')
                ->wherenotin('subscription.subscription_id', $package_count)
                ->orwhere('sent_package.subscription_id', '=', 'NULL')
                ->groupby('subscription_id')
                ->get();

                return view('sentpackage.index', compact('subscriptions', 'genres'));
            }
        }
        
        return redirect('/');
    }

    public function show(/**Post $post**/)
    {
        return view('sentpackage.show');
    }
    
    public function create(package $package)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $date = Carbon::parse($package->package_year."-".$package->package_month)->endOfMonth();

                $package_info = package::select(['package.*', 'product.genre_id'])
                ->leftjoin('packaged_item', 'package.package_id', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', 'product.product_id')
                ->where('package.package_id', '=', $package->package_id)
                ->first();

                if($package_info->genre_id != null)
                {
                    $current_subscriptions = sent_package::select('subscription_id')
                    ->where('package_id', '=', $package->package_id)
                    ->groupby('subscription_id')
                    ->get();

                    $subscriptions = subscription::select(['subscription.*', 'genre.genre_title',
                    DB::raw('LAST_DAY(DATE_ADD(subscription.subscription_date, INTERVAL subscription.subscription_length MONTH)) AS subscription_end_date')])
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->where('genre.genre_id', '=', $package_info->genre_id)
                    ->wherenotin('subscription.subscription_id', $current_subscriptions)
                    ->where('subscription.subscription_date', '<=', $date)
                    ->whereRaw('LAST_DAY(DATE_ADD(subscription.subscription_date, INTERVAL subscription.subscription_length MONTH)) >= ?', [$date])
                    ->groupby('subscription.subscription_id')
                    ->get();
                    
                    return view('sentpackage.create', compact('subscriptions', 'package'));
                
                }
                else
                {
                    session()->put('url_error', 'That package does not have a Genre!');

                    return redirect('/packages');
                }
            }
        }
        return redirect('/');
    }

    public function assign(subscription $subscription)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $subscription = subscription::select(['subscription.*', 'genre.genre_title',
                DB::raw('last_day(date_add(subscription.subscription_date, interval subscription.subscription_length month)) as subscription_end_date')])
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->where('subscription.subscription_id', '=', $subscription->subscription_id)
                ->first();

                $current_packages = sent_package::select('package_id')
                ->where('subscription_id', '=', $subscription->subscription_id)
                ->groupby('package_id')
                ->get();

                $valid_packages = package::select('package_id')
                ->whereRaw("LAST_DAY(CONCAT(package.package_year, '-', package.package_month, '-', '01')) >= ?", [$subscription->subscription_date])
                ->whereRaw("LAST_DAY(CONCAT(package.package_year, '-', package.package_month, '-', '01')) <= ?", [$subscription->subscription_end_date])
                ->get();

                $packages = package::select('package.*')
                ->join('packaged_item', 'package.package_id', 'packaged_item.package_id')
                ->join('product', 'packaged_item.product_id', 'product.product_id')
                ->join('genre', 'product.genre_id', 'genre.genre_id')
                ->where('genre.genre_id', '=', $subscription->genre_id)
                ->wherenotin('package.package_id', $current_packages)
                ->wherein('package.package_id', $valid_packages)
                ->groupby('package.package_id')
                ->get();

                return view('sentpackage.assign', compact('subscription', 'packages'));
            }
        }
        return redirect('/');
    }

    public function edit()
    {

    }

    public function rate(sent_package $sent_package)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'C')
            {
                $package = package::select(['package.*', 'genre.genre_title'])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('client', 'subscription.client_id', '=', 'client.client_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->where('client.user_id', '=', session()->get('user_id'))
                ->where('sent_package.sent_package_id', '=', $sent_package->sent_package_id)
                ->first();
                
                if($package != null)
                {
                    return view('sentpackage.rating', compact('sent_package', 'package'));
                }
            }
        }
        return redirect('/subscriptions');
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

    }

    public function search()
    {
        $text = request('search_text');
        $genre = request('genre_search');

        if($genre != null || $text != null){
            $package_count = subscription::select(['subscription.subscription_id', 'subscription.subscription_length'])
            ->leftjoin('sent_package', 'subscription.subscription_id', '=', 'sent_package.subscription_id')
            ->havingRaw('count(sent_package.subscription_id) > subscription.subscription_length')
            ->groupby('subscription_id')
            ->get();

            $subscriptions_to_search = subscription::select(['subscription.*'])
            ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
            ->join('client', 'subscription.client_id', '=', 'client.client_id')
            ->leftjoin('sent_package', 'subscription.subscription_id', '=', 'sent_package.subscription_id')
            ->wherenotin('subscription.subscription_id', $package_count)
            ->orwhere('sent_package.subscription_id', '=', 'NULL')
            ->groupby('subscription_id')
            ->get();

            try{
                if($text != null){
                    $this->validate(request(), [
                        'search_text' => ['regex:/^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
                    ]);

                    $date = Carbon::parse($text);
                    if(Str::length($text) == 7){
                        $date->endOfMonth();
                    }
                    $date = $date->toDateString();
                }
                else{
                    $date = null;
                }
                
                if($genre == null)
                {
                    $subscriptions_text_search = subscription::select(['subscription.subscription_id'])
                    ->join('client', 'subscription.client_id', '=', 'client.client_id')
                    ->where('subscription.subscription_date', '<=', $date)
                    ->whereRaw('LAST_DAY(date_add(subscription.subscription_date, interval subscription.subscription_length month)) >= ?', [$date])
                    ->groupBy('subscription.subscription_id')
                    ->get();
                }
                else
                {
                    if($date == null)
                    {
                        $subscriptions_text_search = subscription::select(['subscription.subscription_id'])
                        ->join('client', 'subscription.client_id', '=', 'client.client_id')
                        ->where('subscription.genre_id', '=', $genre)
                        ->groupBy('subscription.subscription_id')
                        ->get();
                    }
                    else
                    {
                        $subscriptions_text_search = subscription::select(['subscription.subscription_id'])
                        ->join('client', 'subscription.client_id', '=', 'client.client_id')
                        ->where('subscription.subscription_date', '<=', $date)
                        ->whereRaw('LAST_DAY(date_add(subscription.subscription_date, interval subscription.subscription_length month)) >= ?', [$date])
                        ->where('subscription.genre_id', '=', $genre)
                        ->groupBy('subscription.subscription_id')
                        ->get();
                    }
                }


                $subscriptions = subscription::select(['subscription.*', 'genre.genre_title', 
                DB::raw('LAST_DAY(date_add(subscription.subscription_date, interval subscription.subscription_length month)) as subscription_end_date')])
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->wherein('subscription.subscription_id', $subscriptions_to_search->pluck('subscription_id')->toArray())
                ->wherein('subscription.subscription_id', $subscriptions_text_search)
                ->groupBy('subscription.subscription_id')
                ->get();

                if(count($subscriptions) != 0)
                {
                    $subscribed_genres = subscription::select(['genre_id'])
                    ->join('client', 'subscription.client_id', '=', 'client.client_id')
                    ->get();
            
                    $genres = genre::wherein('genre_id', $subscribed_genres)
                    ->groupBy('genre_id')
                    ->get();

                    return view('sentpackage.index', compact('subscriptions', 'genres'));
                }
                else
                {
                    session()->put('search_error', 'No matches found!');
                }   
            }
            catch(\Exception $err)
            {
                session()->put('search_error', 'Invalid Date Entered!');
            }
        }
        return redirect('/subscriptions/fulfill');
    }

    public function store()
    {
        $this->validate(request(), [
            'subscription_id' => 'required|exists:subscription,subscription_id',
            'package_id' => 'required|exists:package,package_id',
            'create_route' => ['regex:/^[0]$|^[1]$/'],
        ]);

        $create_route = request('create_route');
        $subscription_id = request('subscription_id');
        $package_id = request('package_id');
        $current_date = Carbon::Now()->toDateString();

        $package_items = packaged_item::select(['packaged_item.product_id', 'product.product_quantity'])
        ->join('product', 'packaged_item.product_id', '=', 'product.product_id')
        ->where('packaged_item.package_id', '=', $package_id)
        ->get();

        foreach ($package_items as $packaged_item)
        {
            $newQuantity = $packaged_item->product_quantity - 1;
            product::where('product_id', $packaged_item->product_id)->update([
                'product_quantity' => $newQuantity,
            ]);
        }
        
        sent_package::create([
            'package_id' => $package_id,
            'subscription_id' => $subscription_id,
            'sent_package_date' => $current_date,
        ]);

        if($create_route == 0)
        {
            return redirect('/subscriptions/fulfill/assign/'.$subscription_id);
        }
        else
        {
            return redirect('/packages/fulfill/create/'.$package_id);
        }
    }

    public function update()
    {
        $this->validate(request(), [
            'sent_package_id' => 'required|exists:sent_package,sent_package_id',
            'subscription_id' => 'required|exists:subscription,subscription_id',
            'sent_package_rating' => ['regex:/^([1-5])$|^$/'],
            'sent_package_rating_description' => 'nullable|max:255',
        ]);

        $sent_package_id = request('sent_package_id');
        $subscription_id = request('subscription_id');
        $sent_package_rating = request('sent_package_rating');
        $sent_package_rating_description = request('sent_package_rating_description');

        if($sent_package_rating == null)
        {
            sent_package::where('sent_package_id', $sent_package_id)->update([
                'sent_package_rating' => null,
                'sent_package_rating_description' => null,
            ]);
        }
        else
        {
            sent_package::where('sent_package_id', $sent_package_id)->update([
                'sent_package_rating' => $sent_package_rating,
                'sent_package_rating_description' => $sent_package_rating_description,
            ]);
        }
        
        return redirect('/subscriptions/'.$subscription_id);
    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
