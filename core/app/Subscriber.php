<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public $timestamps = false;

    /**
     * This function is used to subscribed customer
     * @author Chirag Ghevariya
     */
    public function saveSubscriber($request){

       $input = $request->all();

        if (isset($input['email']) && !empty($input['email'])) {
             
            $obj = self::where('email',$input['email'])->first();

            if ($obj == null) {
                
                $obj = new self;
                $obj->email = $input['email'];
                $obj->save();
            }
        }  
    }
}
