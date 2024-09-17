<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','experience_years','availability_status','specialization'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function ($user) {
            $user->technician()->delete();  // Delete related technician record
        });
    }


}
