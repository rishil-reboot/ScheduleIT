<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

     /**
     * This function is used to get header page image url
     * @author Chirag Ghevariya
     */
    public function getHeaderPageImageUrl($default){

        $noImageUrl= $default;
        $imagePath = getRootDirectoryPath().'/assets/front/img/page/'.$this->image;

        $imageUrl= asset('assets/front/img/page/'.$this->image);

        if(file_exists($imagePath) && !empty($this->image)) {

            return $imageUrl;
        }

        return $noImageUrl;
    }
}
