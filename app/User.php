<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';  
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'user_first_name', 'user_last_name', 'user_email_address', 'user_password', 'user_type', 'user_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];

    public function getRouteKeyName()
    {
        return 'user_id';
    }
}
