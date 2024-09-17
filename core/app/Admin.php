<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'username', 'email', 'password', 'first_name', 'last_name', 'image', 'status'
    ];


    public function role() {
      return $this->belongsTo('App\Role');
    }

    /**
     *  This function is used to get user email dropdwon
     * @author Chiag Ghevariya 
     */
    public function getEmailDropdown(){

        $users = self::where('status',1)->get();
        $userArray = array();

        foreach($users as $key=>$v){

            $name = $v->first_name.' '.$v->last_name.' ('.$v->email.')';

            $userArray[$v->id] = $name;
        }

        return $userArray;
    }
}
