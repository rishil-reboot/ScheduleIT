<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;
class Page extends Model
{

    const FAQ_FOR_LEGENDS_EDITOR_PAGE_ID = 43;
    const IMAGE_TO_PDF_CONSTANT = 47;
    const METADATA_VIEWER_CONSTANT = 48;
    const TERMS_AND_CONDITIONS = 23;

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    /**
     * This function is used to get header page image url
     * @author Chirag Ghevariya
     */
    public function getHeaderPageImageUrl($default)
    {

        $noImageUrl = $default;
        $imagePath = getRootDirectoryPath() . '/assets/front/img/page/' . $this->image;
        // dd($imagePath);
        $imageUrl = asset('assets/front/img/page/' . $this->image);

        if (file_exists($imagePath) && !empty($this->image)) {

            return $imageUrl;
        }

        return $noImageUrl;
    }

    public function features() {
        return $this->hasMany('App\Feature','id');
    }
}
