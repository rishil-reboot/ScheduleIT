<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyPortfolioCategory extends Model
{
    protected $table = 'my_portfolio_categories';

    /**
     * This function is used to get portfolio data
     * @author Chirag Ghevariya
     */
    public function portfolio() {

        return $this->belongsTo('App\Portfolio','portfolio_id','id');
    }

    /**
     * This function is used to get portfolio category data
     * @author Chirag Ghevariya
     */
    public function portfolioCategory() {

        return $this->belongsTo('App\PortfolioCategory','id','category_id');
    }
}
