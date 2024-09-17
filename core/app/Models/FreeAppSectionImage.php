<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FreeAppSection;
class FreeAppSectionImage extends Model
{
    protected $table='free_app_section_images';
    protected $fillable=[
        'free_app_section_id','image'
    ];
    use HasFactory;
    public function freeAppsection()
    {
        return $this->belongsTo(FreeAppSection::class);
    }
}
