<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    //
    protected $table = 'genre';  
    public $timestamps = false;
    protected $fillable = ['genre_id', 'genre_title', 'genre_description'];

    public function getRouteKeyName()
    {
        return 'genre_id';
    }

    public function banner($value)
    {
        if (file_exists(public_path().'/images/genre-image-'.$value.'.jpg')) {
            return true;
        } else {
            return false;
        }     
    }
}
