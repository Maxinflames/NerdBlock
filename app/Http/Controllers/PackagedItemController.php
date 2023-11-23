<?php

namespace App\Http\Controllers;

use App\package;
use App\product;
use App\packaged_item;

use DB;
use Session;

use Illuminate\Http\Request;

class PackagedItemController extends Controller
{
    public function create(package $package)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
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
        }
    }

    public function assign(product $product)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                if(packaged_item::select(['*'])->where('packaged_item.product_id', $product->product_id)->exists())
                {
                    return redirect('/products/'.$product->product_id);
                }
                $matching_genre_packages = DB::table('package')->select(['package.*', 'product.genre_id'])
                ->leftjoin('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->where('product.genre_id', $product->genre_id)
                ->groupBy('package.package_id')
                ->get();
                
                $temp_package_array = DB::table('package')->select(['package.package_month', 'package.package_year'])
                ->leftjoin('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->where('product.genre_id', $product->genre_id)
                ->groupBy('package.package_id')
                ->get();


                $other_qualified_packages = DB::table('package')->select(['package.*', 'product.genre_id'])
                ->leftjoin('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->leftjoin('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->whereRaw(DB::raw("(package.package_month, package.package_year) not in
                    (select package.package_month, package.package_year from package
                    left JOIN packaged_item ON package.package_id = packaged_item.package_id
                    left JOIN product ON packaged_item.product_id = product.product_id
                    where product.genre_id = '.$product->genre_id.'
                    group by package.package_id)"))
                ->where('product.genre_id', null)
                ->get();


                $merged_packages = $matching_genre_packages->concat($other_qualified_packages);

                $qualified_packages = $merged_packages->sortByDesc('package_month');

                return view('packagedItem.assign', compact('qualified_packages', 'product'));
            }
        }
    }

    public function store()
    {
        $package_id = request('package_id');
        $product_id = request('product_id');

        $this->validate(request(), [
            'package_id' => 'required|numeric|exists:package,package_id',
            'product_id' => 'required|numeric|exists:product,product_id|unique:packaged_item'
        ]);
        
        packaged_item::create([
            'package_id' => $package_id,
            'product_id' => $product_id,
        ]);

        return redirect('/packages/'.$package_id);
    }
}
