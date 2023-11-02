<?php

namespace App\Http\Controllers;

use App\package;
use App\product;
use App\packaged_item;

use DB;

use Illuminate\Http\Request;

class PackagedItemController extends Controller
{
    //
    public function index()
    {
        return view('packagedItem.index');
    }

    public function show()
    {
        return view('packagedItem.show');
    }
    
    public function create(package $package)
    {
        $retrieved_package = package::select(['package.*', 'product.genre_id'])
        ->leftjoin('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
        ->leftjoin('product', 'packaged_item.product_id', '=', 'product.product_id')
        ->where('package.package_id', $package->package_id)
        ->first();


        if($retrieved_package->genre_id == null)
        {
            $products = DB::select( DB::raw("SELECT product.*, packaged_item.packaged_item_id FROM product
            LEFT JOIN packaged_item ON product.product_id = packaged_item.product_id
            WHERE (product.genre_id) NOT IN (SELECT product.genre_id FROM package
            LEFT JOIN packaged_item ON package.package_id = packaged_item.package_id
            LEFT JOIN product ON packaged_item.product_id = product.product_id
            WHERE (package_mONth, package_year, genre_id) IN 
            (SELECT package_mONth, package_year, product.genre_id from package
            LEFT JOIN packaged_item ON package.package_id = packaged_item.package_id
            LEFT JOIN product ON packaged_item.product_id = product.product_id
            GROUP BY package.package_id)
            AND package.package_month = '$package->package_month'
            AND package.package_year = '$package->package_year'
            GROUP BY package.package_id)
            AND packaged_item.product_id IS NULL;"));
        }
        else
        {            
            $products = DB::select( DB::raw("SELECT product.*, packaged_item.packaged_item_id FROM product
            LEFT JOIN packaged_item ON product.product_id = packaged_item.product_id
            WHERE (product.genre_id) IN (SELECT product.genre_id FROM package
            LEFT JOIN packaged_item ON package.package_id = packaged_item.package_id
            LEFT JOIN product ON packaged_item.product_id = product.product_id
            WHERE (package_mONth, package_year, genre_id) IN 
            (SELECT package_mONth, package_year, product.genre_id from package
            LEFT JOIN packaged_item ON package.package_id = packaged_item.package_id
            LEFT JOIN product ON packaged_item.product_id = product.product_id
            GROUP BY package.package_id)
            AND package.package_month = '$package->package_month'
            AND package.package_year = '$package->package_year'
            AND product.genre_id = '$retrieved_package->genre_id'
            GROUP BY package.package_id)
            AND packaged_item.product_id IS NULL;"));
        }

        return view('packagedItem.create', compact('retrieved_package', 'products'));
    }

    public function assign(product $product)
    {
        $qualified_packages = package::select(['package.*', 'product.genre_id'])
        ->leftjoin('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
        ->leftjoin('product', 'packaged_item.product_id', '=', 'product.product_id')
        ->where('package.package_id', $package->package_id)
        ->get();

        if($retrieved_package->genre_id == null)
        {
            $products = product::select(['product.*'])
            ->leftjoin('packaged_item', 'product.product_id', '=', 'packaged_item.product_id')
            ->whereNull('packaged_item.product_id')
            ->get();
        }
        else
        {
            $products = product::select(['product.*'])
            ->leftjoin('packaged_item', 'product.product_id', '=', 'packaged_item.product_id')
            ->where('product.genre_id', $retrieved_package->genre_id)
            ->whereNull('packaged_item.product_id')
            ->get();
        }
        

        return view('packagedItem.create', compact('package', 'products'));
    }

    public function edit(/**Post $post**/)
    {
        return view('packagedItem.edit');
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
        $package_id = request('package_id');
        $product_id = request('product_id');

        if(Package::where('package_id', "=", $package_id)->exists() && Product::where('product_id', "=", $product_id)->exists())
        {
            packaged_item::create([
                'package_id' => $package_id,
                'product_id' => $product_id,
            ]);

            return redirect('/packaged-item/create/'.$package_id);
        }
        return redirect('/packaged-item');
    }

    public function update()
    {

    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
