<?php

namespace App\Http\Controllers;

use App\product;
use App\shipment_item;
use App\shipment;

use Session;
use DB;

use Illuminate\Http\Request;

class ShipmentItemController extends Controller
{
    //
    public function index()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {
                return view('ShipmentItem.index');
            }
        }
    }

    public function show(shipment_item $shipment_item)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E' )
            {

                return view('ShipmentItem.show', compact('shipment_item'));
            }
        }
    }
    
    public function create(shipment $shipment)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                $products = DB::select(DB::raw("SELECT product.* FROM product
                WHERE (product.product_id) NOT IN 
                (SELECT shipment_item.product_id FROM shipment_item
                WHERE shipment_item.shipment_id = '$shipment->shipment_id')
                GROUP BY product.product_id;"));

                return view('ShipmentItem.create', compact('shipment', 'products'));
            }
        }
    }

    public function edit(shipment_item $shipment_item)
    {        
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                return view('ShipmentItem.edit', compact('shipment_item'));
            }
        }
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

    }

    public function search()
    {

    }

    public function store()
    {
        $product_id = request('product_id');
        $shipment_item_unit_cost = request('shipment_item_unit_cost');
        $shipment_item_quantity = request('shipment_item_quantity');
        $shipment = shipment::select(['*'])
        ->where('shipment_id', request('shipment_id'))
        ->first();

        switch (request()->input('action')) 
        {
            case 'search':
                $text = request('search_text');

/**  I truly dont know why the following does not work, using DB raw instead
            *    $products = product::select(['product.*'])
            *    ->leftjoin('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
            *    ->where(function($q) use($text){
            *        $q->where('product.product_title', 'like', '%' . $text . '%')
            *        ->orwhere('product.product_description', 'like', '%' . $text . '%')
            *        ->orwhere('product.product_manufacturer', 'like', '%' . $text . '%')
            *        ->orwhere('product.product_brand', 'like', '%' . $text . '%')
            *        ->orwhere('product.product_license', 'like', '%' . $text . '%');
            *    })
            *    ->where(function($q) use($shipment){
            *        $q->where('shipment_item.shipment_id', '!=', $shipment->shipment_id)
            *        ->orWhereNull('shipment_item.shipment_id');
            *    })
            *    ->groupBy('product.product_id')
            *    ->get();
*/
                $products = DB::select(DB::raw("SELECT product.* FROM product
                LEFT JOIN shipment_item ON product.product_id = shipment_item.product_id
                WHERE (shipment_item.shipment_id != $shipment->shipment_id
                OR shipment_item.shipment_id IS NULL)
                AND (product.product_title LIKE '%assort%' 
                OR product.product_description LIKE '%assort%' 
                OR product.product_manufacturer LIKE '%assort%' 
                OR product.product_brand LIKE '%assort%' 
                OR product.product_license LIKE '%assort%')
                GROUP BY product.product_id;"));
                

                if(count($products) != 0)
                {
                    return view('ShipmentItem.create', compact('shipment', 'products', 'product_id', 'shipment_item_unit_cost', 'shipment_item_quantity'));
                }
                else{
                    $products = product::select(['product.*'])
                    ->leftjoin('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
                    ->where('shipment_item.shipment_id', '!=', $shipment->shipment_id)
                    ->orWhereNull('shipment_item.shipment_id')
                    ->groupBy('product.product_id')
                    ->get();

                    session()->put('search_error', 'No matches found!');
                    return view('ShipmentItem.create', compact('shipment', 'products', 'product_id', 'shipment_item_unit_cost', 'shipment_item_quantity'));
                }
    
            case 'submit':
                $check_product = product::select(['product.*'])
                ->join('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
                ->where('shipment_item.shipment_id', request('shipment_id'))
                ->where('product.product_id', request('product_id'))
                ->get();

                if($check_product->count() == 0)
                {
                    $this->validate(request(), [
                        'product_id' => 'required|exists:product,product_id',
                        'shipment_id' => 'required|exists:shipment,shipment_id',
                        'shipment_item_quantity' => 'required|numeric|min:0',
                        'shipment_item_unit_cost' => ['regex:/^([0-9]+\.[0-9]{2})$|^([0-9]+)$|^([0-9]+\.[0-9]{1})$/'],
                    ]);
                    shipment_item::create([
                        'product_id' => request('product_id'),
                        'shipment_id' => request('shipment_id'),
                        'shipment_item_quantity' => request('shipment_item_quantity'),
                        'shipment_item_unit_cost' => request('shipment_item_unit_cost'),
                    ]);

                    $shipment_cost = shipment::select('shipment_item.shipment_item_unit_cost')
                    ->join('shipment_item', 'shipment.shipment_id', '=', 'shipment_item.shipment_id')
                    ->where('shipment_item.product_id', '=', $product_id)
                    ->orderBy('shipment.shipment_date', 'desc')
                    ->first();

                    $product = product::select(['*'])
                    ->where('product_id', '=', $product_id)
                    ->first();

                    dd($shipment_cost->shipment_item_unit_cost);

                    if($shipment->shipment_destination == "NerdBlock")
                    {
                        $newQuantity = $product->product_quantity + $shipment_item_quantity;
                    }
                    else
                    {
                        $newQuantity = $product->product_quantity - $shipment_item_quantity;
                    }

                    product::where('product_id', $product_id)->update([
                        'product_quantity' => $newQuantity,
                        'product_cost' => $shipment_cost->shipment_item_unit_cost,
                    ]);
                }
                else
                {
                    session()->put('entryError', 'That product is already apart of the shipment.');
                    
                    $this->validate(request(), [
                        'product_id' => 'required|exists:product,product_id',
                        'shipment_id' => 'required|exists:shipment,shipment_id',
                        'shipment_item_quantity' => 'required|numeric|min:0',
                        'shipment_item_unit_cost' => ['regex:/^([0-9]+\.[0-9]{2})$|^([0-9]+)$|^([0-9]+\.[0-9]{1})$/'],
                    ]);

                    return redirect('/shipment-item/create/'.request('shipment_id'));
                }
        }
        return redirect('/shipments/'.request('shipment_id'));
    }

    public function update()
    {

    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
