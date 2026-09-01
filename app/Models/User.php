<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['img_url','name','email','mobile','password','otp','status','role','permissions'];
    protected $attributes = ['otp' => '0'];
    protected $hidden = ['password', 'otp'];

     // Ensure otp_expires_at is cast as a datetime
    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];

    public function orders()
{
    return $this->hasMany(Order::class, 'user_id');
}


}
