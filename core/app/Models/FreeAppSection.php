<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FreeAppSectionImage;

class FreeAppSection extends Model
{
    protected $table='free_app_section';
    protected $fillable=[
        'language_id','title','subtitle','slug','image'
    ];
    use HasFactory;

    public function freeAppsectionImages()
    {
        return $this->hasMany(FreeAppSectionImage::class);
    }
}


