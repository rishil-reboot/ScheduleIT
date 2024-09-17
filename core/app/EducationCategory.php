<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationCategory extends Model
{

    protected $table = 'educationcategories';

    public $timestamps = false;

    public function educationBlogs() {

      return $this->hasMany('App\EducationBlog','education_category_id','id');
      
    }
}
