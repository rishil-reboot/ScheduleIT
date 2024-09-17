<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InboxwebmailAccount extends Model
{
    protected $guarded = ['id'];

    /**
     * This function is used to get email server setting information
     * @author Chirag Ghevariya
     */
    public function emailServer(){

        return $this->belongsTo('App\EmailServer','email_server_id','id');
    }
    
}