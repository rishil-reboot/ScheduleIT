<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function language() {
        return $this->belongsTo('App\Language');
    }

    /**
     * This function is used to get media dropdown with type
     * @author Chirag Ghevariya 
     */
    public function getMedaiTypeDropDownWithType($type){

        return \App\Gallery::where('media_type',$type)->pluck('title','id')->toArray();
    }

    /**
     * This function is used to get all media dropdown
     * @author Chirag Ghevariya 
     */
    public function getMedaiTypeDropDown(){

        return \App\Gallery::whereNotNull('media_type')->pluck('title','id')->toArray();
    }

     /**
     * This function is used to get all media
     * @author Durgaraj Chauhan 
     */
    public function getMedai() {
        return \App\Gallery::all();
    }
    
    /**
     * This function is used to get filesize
     * @author Chirag Ghevariya
     */
    public function getMedaiFileSize(){

        $fSize ="";

        if($this->media_type == 1){

            if ($this->image !=null) {
                
                $path = getMediaTypeImagePath().'/'.$this->image;

                if (file_exists($path)) {

                    $fSize = filesize($path);
                }
            }

        }elseif($this->media_type == 2){

            if ($this->document_file !=null) {
                    
                $path = getMediaTypeDocumentPath().'/'.$this->document_file;

                if (file_exists($path)) {

                    $fSize = filesize($path);
                }
            }

        }elseif($this->media_type == 3){

            $path = getMediaTypeVideoPath().'/'.$this->video_name;

            if (file_exists($path)) {

                $fSize = filesize($path);
              
            }

        }elseif($this->media_type == 4){

            $path = getMediaTypeAudioPath().'/'.$this->audio_file;

            if (file_exists($path)) {

                $fSize = filesize($path);
            }
        }
        
        if ($fSize !="") {
            
            return getFormatSize($fSize);
        }

    }

    /**
     * This function is used to get filesize
     * @author Chirag Ghevariya
     */
    public function getTotalMedaiFileSize(){

        $gallery = \App\Gallery::whereNotNull('media_type')->get();

        $fSize = 0;
        
        if (isset($gallery) && !$gallery->isEmpty()) {
            
            foreach($gallery as $key=>$v){

                if($v->media_type == 1){
                        
                    if ($v->image !=null) {
                        
                        $path = getMediaTypeImagePath().'/'.$v->image;
                        
                        if (file_exists($path)) {
                            
                            $fSize += filesize($path);
                        }
                    }
                }

                if($v->media_type == 2){

                    if ($v->document_file !=null) {
                            
                        $path = getMediaTypeDocumentPath().'/'.$v->document_file;

                        if (file_exists($path)) {

                            $fSize += filesize($path);
                        }
                    }

                }

                if($v->media_type == 3){

                    $path = getMediaTypeVideoPath().'/'.$v->video_name;

                    if (file_exists($path)) {

                        $fSize += filesize($path);
                    }

                }

                if($v->media_type == 4){

                    $path = getMediaTypeAudioPath().'/'.$v->audio_file;

                    if (file_exists($path)) {

                        $fSize += filesize($path);
                    }
                }

            }

        }

        return getFormatSize($fSize);
    }
    
    /**
     * This function is used to get all type of Media path
     * @author Chirag Ghevariya
    */
    public function getMediaFilePath(){

        $filePath = '';

        if($this->media_type == 1){
                        
            if ($this->image !=null) {
                
                $path = getMediaTypeImagePath().'/'.$this->image;
                    
                if (file_exists($path)) {
                    
                    $filePath = getMediaTypeImageURL().'/'.$this->image;
                }
            }

        }elseif($this->media_type == 2){

            if ($this->document_file !=null) {
                    
                $path = getMediaTypeDocumentPath().'/'.$this->document_file;

                if (file_exists($path)) {

                    $filePath = getMediaTypeDocumentURL().'/'.$this->document_file;
                }
            }

        }elseif($this->media_type == 3){

            
            $filePath = $this->videoUrl;
            

        }elseif($this->media_type == 4){

            $path = getMediaTypeAudioPath().'/'.$this->audio_file;

            if (file_exists($path)) {

                $filePath = getMediaTypeAudioURL().'/'.$this->audio_file;
            }
        }

        return $filePath;
    }
}

