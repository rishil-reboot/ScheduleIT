<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id','industry_type','establised_year'
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
