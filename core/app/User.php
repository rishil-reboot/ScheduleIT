<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import the JWTSubject interface

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'photo',
        'username',
        'password',
        'number',
        'city',
        'state',
        'address',
        'country',
        'billing_fname',
        'billing_lname',
        'billing_email',
        'billing_photo',
        'billing_number',
        'billing_city',
        'billing_state',
        'billing_address',
        'billing_country',
        'shpping_fname',
        'shpping_lname',
        'shpping_email',
        'shpping_photo',
        'shpping_number',
        'shpping_city',
        'shpping_state',
        'shpping_address',
        'shpping_country',
        'status',
        'verification_link',
        'email_verified',
        'credit',
        'fb_id',
        'online',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\ProductOrder');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }

    public function scopeActive($query)
    {
        return $query->whereStatus('1');
    }

    public function scopeOnline($query)
    {
        return $query->whereOnline('1');
    }

    public function chat()
    {
        return $this->hasMany('App\BookingChat');
    }

    public function booking()
    {
        return $this->hasMany('App\Booking');
    }

    public function transaction()
    {
        return $this->hasMany('App\BookingTransaction');
    }

    public function loginSecurity()
    {
        return $this->hasOne(LoginSecurity::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
