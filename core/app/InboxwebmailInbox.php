<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InboxwebmailInbox extends Model
{
    protected $guarded = ['id'];

    /**
     * This function is used to get inbox account details
     * @author Chirag Ghevariya
     */
    public function getInboxAccount(){

        return $this->belongsTo('App\InboxwebmailAccount','account_id','id');
    }

}