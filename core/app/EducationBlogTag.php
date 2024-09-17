<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EducationTag;
use App\EducationBlog;

class EducationBlogTag extends Model
{

    protected $table = 'educationblogtags';

    public $timestamps = false;

    public function educationTag() {

      return $this->belongsTo('App\EducationTag','education_tag_id','id');
    }

    public function educationBlog() {
      
      return $this->belongsTo('App\EducationBlog','education_blog_id','id');
    }

    public function saveUpdateTags($blog,$input){

        self::where('education_blog_id',$blog->id)->delete();
                
        if (isset($input['education_tag_id']) && !empty($input['education_tag_id'])) {

            foreach ($input['education_tag_id'] as $key => $value) {
                
                $obj = new self;
                $obj->education_tag_id = $value;
                $obj->education_blog_id = $blog->id;
                $obj->save();
            }
        }
    }
}
