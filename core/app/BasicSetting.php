<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicSetting extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

    /**
     * This relationsip is used to get page detail associate with quote
     * @author Chirag Ghevariya
     */
    public function getQuotePage() {
        return $this->belongsTo('App\Page','quote_menu_page_id','id');
    }
}
