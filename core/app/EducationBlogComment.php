<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationBlogComment extends Model
{   
    protected $table = 'education_blog_comments';

    public $timestamps = true;

    public function educationBlog() {

      return $this->belongsTo('App\EducationBlog','education_blog_id','id');
    }
}
