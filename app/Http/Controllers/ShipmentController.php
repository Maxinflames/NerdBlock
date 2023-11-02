<?php

namespace App\Http\Controllers;

use App\shipment;
use App\product;
use App\shipment_item;

use Session;

use Carbon\Carbon;

use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $shipments = shipment::select(['*'])
                ->orderBy('shipment.shipment_date', 'desc')
                ->get();
                return view('Shipment.index', compact('shipments'));
            }
        }
        return redirect('/');
    }

    public function show(shipment $shipment)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                $associated_products = shipment_item::select(['shipment_item.*', 'product.*'])
                ->join('product', 'shipment_item.product_id', '=', 'product.product_id')
                ->join('shipment', 'shipment_item.shipment_id', '=', 'shipment.shipment_id')
                ->where('shipment_item.shipment_id', "=", $shipment->shipment_id)
                ->get();

                return view('Shipment.show', compact('shipment','associated_products'));
            }
        }
        return redirect('/');
    }
    
    public function create()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                return view('Shipment.create');
            }
        }
    }

    public function edit(shipment $shipment)
    {        
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                return view('Shipment.edit', compact('shipment'));
            }
        }
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

    }

    public function search()
    {
        $text = request('search_text');

        
        if($text != "" || $text != null)
        {
            $shipments = shipment::select(['shipment.*'])
            ->join('shipment_item', 'shipment.shipment_id', '=', 'shipment_item.shipment_id')
            ->join('product', 'shipment_item.product_id', '=', 'product.product_id')
            ->where('shipment.shipment_date', 'like', '%' . $text . '%')
            ->orwhere('product_title', 'like', '%' . $text . '%')
            ->orwhere('product_description', 'like', '%' . $text . '%')
            ->orwhere('product_manufacturer', 'like', '%' . $text . '%')
            ->orwhere('product_brand', 'like', '%' . $text . '%')
            ->orwhere('product_license', 'like', '%' . $text . '%')
            ->orderBy('shipment.shipment_date', 'desc')
            ->get();            
            
            // If the post exists that is equal to Id, redirect to the view page
            if ($shipments->count() != 0) {

                return view('shipment.index', compact('shipments'));
            }

            // Otherwise, redirect back to user index, with a server variable status initialized 
            else {
                session()->put('search_error', 'No matches found!');
            }
        }
        return redirect('/shipments');
    }

    public function store()
    {
        try{
            $date = Carbon::parse(request('shipment_date'));

            $this->validate(request(), [
                'shipment_date' => 'required|string|min:10|max:10',
                'shipment_destination' => 'required|string'
            ]);  

            shipment::create([
                'shipment_date' => request('shipment_date'),
                'shipment_destination' => request('shipment_destination'),
            ]);

            return redirect('/shipments');
        }
        catch(\Exception $e){
            session()->put('ShipmentDateError', 'Please enter a valid date using the format! (YYYY-MM-DD). Entered: '.request('shipment_date'));
            $this->validate(request(), [
                'shipment_date' => 'required|string|min:10|max:10',
                'shipment_destination' => 'required|string'
            ]);  
            return redirect('/shipments/create');
        }
    }

    public function update()
    {
        try{
            $date = Carbon::parse(request('shipment_date'));

            $this->validate(request(), [
                'shipment_id' => 'required|exists:shipment,shipment_id',
                'shipment_date' => 'required|string|min:10|max:10',
                'shipment_destination' => 'required|string'
            ]);  

            shipment::where('shipment_id', request('shipment_id'))->update([
                'shipment_date' => request('shipment_date'),
                'shipment_destination' => request('shipment_destination'),
            ]);

            return redirect('/shipments');
        }
        catch(\Exception $e){
            session()->put('ShipmentDateError', 'Please enter a valid date using the format! (YYYY-MM-DD). Entered: '.request('shipment_date'));
            $this->validate(request(), [
                'shipment_date' => 'required|string|min:10|max:10',
                'shipment_destination' => 'required|string'
            ]);  
            return redirect('/shipments/edit/'.request('shipment_id'));
        }
    }

    // Likely will be given no functionality
    public function destroy()
    {
        
    }
}
