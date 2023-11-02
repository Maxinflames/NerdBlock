<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    protected $table = 'product';  
    public $timestamps = false;
    protected $fillable = ['product_id', 'genre_id', 'product_title', 
    'product_description', 'product_cost', 'product_manufacturer', 
    'product_brand', 'product_license', 'product_quantity'];

    public function getRouteKeyName()
    {
        return 'product_id';
    }
    //
}
