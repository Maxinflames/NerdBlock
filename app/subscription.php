<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscription extends Model
{
    //
    protected $table = 'subscription';  
    public $timestamps = false;
    protected $fillable = ['subscription_id', 'client_id', 'genre_id', 'subscription_date', 'subscription_length', 'subscription_cost'];

    
    public function getRouteKeyName()
    {
        return 'subscription_id';
    }
}
