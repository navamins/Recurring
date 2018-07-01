<?php

namespace App;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';  // name table in DB
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'emp_code', 'name', 'lastname', 'email', 'password', 'role', 'useflag', 'create_user', 'create_date', 'update_user', 'update_date', 'log'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function permission()
    // {
    //     return $this->belongsTo('App\Permission', 'permission','id');
    // }
}
