<?php

namespace App\Http\Controllers;

use App\genre;
use App\product;
use App\packaged_item;
use App\shipment;

use Session;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $products = product::all();

                return view('product.index', compact('products'));
            }
        }
        return redirect('/');
    }

    public function show(product $product)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $product_data = product::select(['product.*', 'packaged_item.packaged_item_id', 'packaged_item.package_id'])
                ->leftjoin('packaged_item', 'product.product_id', '=', 'packaged_item.product_id')
                ->where('product.product_id', $product->product_id)
                ->first();

                $associated_shipments = shipment::select(['shipment.*','shipment_item.shipment_item_quantity','shipment_item.shipment_item_unit_cost'])
                ->join('shipment_item', 'shipment.shipment_id', '=', 'shipment_item.shipment_id')
                ->where('shipment_item.product_id', $product->product_id)
                ->orderBy('shipment.shipment_date', 'desc')
                ->get();

                return view('product.show', compact('product_data', 'associated_shipments'));
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
                $genres = genre::all();

                return view('product.create', compact('genres'));
            }
        }
        return redirect('/');
    }

    public function edit(product $product)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                $genres = genre::all();

                return view('product.edit', compact('product', 'genres'));
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
        $text = request('search_text');

        $products = product::select(['product.*'])
        ->where('product_title', 'like', '%' . $text . '%')
        ->orwhere('product_description', 'like', '%' . $text . '%')
        ->orwhere('product_manufacturer', 'like', '%' . $text . '%')
        ->orwhere('product_brand', 'like', '%' . $text . '%')
        ->orwhere('product_license', 'like', '%' . $text . '%')
        ->get();

        $count = product::select(['product.*'])
        ->where('product_title', 'like', '%' . $text . '%')
        ->orwhere('product_description', 'like', '%' . $text . '%')
        ->orwhere('product_manufacturer', 'like', '%' . $text . '%')
        ->orwhere('product_brand', 'like', '%' . $text . '%')
        ->orwhere('product_license', 'like', '%' . $text . '%')
        ->count();

        // If the post exists that is equal to Id, redirect to the view page
        if ($count != 0) {

            return view('product.index', compact('products'));
        }

        // Otherwise, redirect back to user index, with a server variable status initialized 
        else {
            session()->put('search_error', 'No matches found!');
            return redirect('/products');
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'genre_id' => 'required|exists:genre,genre_id',
            'product_title' => 'required|string|max:50',
            'product_description' => 'required|string|max:255',
            'product_title' => 'required|string|max:50',
            'product_cost' => ['regex:/^([0-9]+\.[0-9]{2})$|^([0-9]+)$|^([0-9]+\.[0-9]{1})$/'],
            'product_manufacturer' => 'nullable|string|max:50',
            'product_brand' => 'nullable|string|max:50',
            'product_license' => 'nullable|string|max:50',
            'product_quantity' => 'required|numeric',
        ]);        

        product::create([
            'genre_id' => request('genre_id'),
            'product_title' => request('product_title'),
            'product_description' => request('product_description'),
            'product_title' => request('product_title'),
            'product_cost' => request('product_cost'),
            'product_manufacturer' => request('product_manufacturer'),
            'product_brand' => request('product_brand'),
            'product_license' => request('product_license'),
            'product_quantity' => request('product_quantity'),
        ]);
        
        return redirect('/products');
    }

    public function update()
    {
        $this->validate(request(), [
            'product_id' => 'required|exists:product,product_id',
            'genre_id' => 'required|exists:genre,genre_id',
            'product_title' => 'required|string|max:50',
            'product_description' => 'required|string|max:255',
            'product_title' => 'required|string|max:50',
            'product_cost' => ['regex:/^([0-9]+\.[0-9]{2})$|^([0-9]+)$|^([0-9]+\.[0-9]{1})$/'],
            'product_manufacturer' => 'nullable|string|max:50',
            'product_brand' => 'nullable|string|max:50',
            'product_license' => 'nullable|string|max:50',
            'product_quantity' => 'required|numeric',
        ]);        

        product::where('product_id', request('product_id'))->update([
            'genre_id' => request('genre_id'),
            'product_title' => request('product_title'),
            'product_description' => request('product_description'),
            'product_title' => request('product_title'),
            'product_cost' => request('product_cost'),
            'product_manufacturer' => request('product_manufacturer'),
            'product_brand' => request('product_brand'),
            'product_license' => request('product_license'),
            'product_quantity' => request('product_quantity'),
        ]);
        
        return redirect('/products');
    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
