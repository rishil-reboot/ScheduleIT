<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationTag extends Model
{

    protected $table = 'educationtags';

    public $timestamps = false;

    public function educationBlogTags() {

      return $this->hasMany('App\EducationBlogTag','education_tag_id','id');
      
    }
}
