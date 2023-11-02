<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $table = 'client';  
    public $timestamps = false;
    protected $fillable = [
        'client_id', 'user_id', 'client_country', 'client_region', 'client_city', 'client_address', 'client_region_post_code', 'client_country_code', 'client_telephone',
    ];
    //
    
    public function getRouteKeyName()
    {
        return 'client_id';
    }
}
