<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shipment extends Model
{
    //
    protected $table = 'shipment';  
    public $timestamps = false;
    protected $fillable = ['shipment_id', 'shipment_date', 'shipment_destination'];

    public function getRouteKeyName()
    {
        return 'shipment_id';
    }
}
