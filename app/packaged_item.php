<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class packaged_item extends Model
{
    //
    protected $table = 'packaged_item';  
    public $timestamps = false;
    protected $fillable = ['packaged_item_id', 'product_id', 'package_id'];

    public function getRouteKeyName()
    {
        return 'packaged_item_id';
    }
}
