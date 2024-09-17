<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function admins() {
      return $this->hasMany('App\Admin');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'role_id');
    }

}
