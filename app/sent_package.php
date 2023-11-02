<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sent_package extends Model
{
    //
    protected $table = 'sent_package';  
    public $timestamps = false;
    protected $fillable = ['sent_package_id', 'subscription_id', 'package_id', 'sent_package_date'];

    public function getRouteKeyName()
    {
        return 'sent_package_id';
    }
}
