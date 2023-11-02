<?php

namespace App\Http\Controllers;

use App\package;
use App\product;
use App\packaged_item;

use Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $packages = package::select(['package.*', 'genre.genre_title'])
                ->leftjoin('packaged_item', 'package.package_id', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', 'product.product_id')
                ->leftjoin('genre', 'product.genre_id', 'genre.genre_id')
                ->groupBy('package.package_id')
                ->get();

                return view('package.index', compact('packages'));
            }
        }
        return redirect('/');
    }

    public function show(package $package)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $retrieved_package = package::select(['package.*', 'product.genre_id'])
                ->leftjoin('packaged_item', 'package.package_id', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', 'product.product_id')
                ->where('package.package_id', $package->package_id)
                ->groupBy('package.package_id')
                ->first();

                $associated_products = product::select(['product.*', 'packaged_item.packaged_item_id'])
                ->join('packaged_item', 'product.product_id', '=', 'packaged_item.product_id')
                ->where('packaged_item.package_id', $package->package_id)
                ->get();
                
                return view('package.show', compact('retrieved_package', 'associated_products'));
            }
        }
        return redirect('/');
    }
    
    public function create()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                return view('package.create');
            }
        }
        return redirect('/');
    }

    public function edit(package $package)
    {        
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                return view('package.edit', compact('package'));
            }
        }
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {
        return redirect('/');
    }

    public function search()
    {

    }

    public function store()
    {        
        $this->validate(request(), [
            'package_month' => 'required|numeric|min:1|max:12',
            'package_year' => 'required|numeric|min:2014'
        ]);  

        package::create([
            'package_month' => request('package_month'),
            'package_year' => request('package_year'),
        ]);

        return redirect('/packages');
    }

    public function update()
    {
        $this->validate(request(), [
            'package_month' => 'required|numeric|min:1|max:12',
            'package_year' => 'required|numeric|min:2014'
        ]);        

        package::where('package_id', request('package_id'))->update([
            'package_month' => request('package_month'),
            'package_year' => request('package_year'),
        ]);

        return redirect('/packages');
    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
