<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationBlog extends Model
{   
    protected $table = 'educationblogs';

    public $timestamps = true;

    public function educationCategory() {

      return $this->belongsTo('App\EducationCategory','education_category_id','id');
    }

    public function educationBlogTag() {

      return $this->hasMany('App\EducationBlogTag','education_blog_id','id');
    }

    public function educationBlogComment() {

      return $this->hasMany('App\EducationBlogComment','education_blog_id','id');
    }

    public function language() {
        
        return $this->belongsTo('App\Language');
    }
}
