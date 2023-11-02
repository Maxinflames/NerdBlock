<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    //
    protected $table = 'package';  
    public $timestamps = false;
    protected $fillable = ['package_id', 'package_month', 'package_year'];

    public function getRouteKeyName()
    {
        return 'package_id';
    }
}
