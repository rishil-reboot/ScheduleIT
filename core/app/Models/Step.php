<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table= 'steps';
    protected $fillable=[
        'step_number','title',
        'description','image','serial_number'
    ];

    use HasFactory;
}
