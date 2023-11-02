<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shipment_item extends Model
{
    //
    protected $table = 'shipment_item';  
    public $timestamps = false;
    protected $fillable = ['shipment_item_id', 'product_id', 'shipment_id', 
    'shipment_item_quantity', 'shipment_item_unit_cost'];

    public function getRouteKeyName()
    {
        return 'shipment_item_id';
    }
}
