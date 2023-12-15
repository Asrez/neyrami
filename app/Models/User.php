<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const MAIL='mail';
    CONST SMS='sms';
    CONST TELEFRAM='telefram';
    CONST ALLTYPE=[self::MAIL,self::SMS,self::TELEFRAM];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enabled_notification_services'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setNotificationService($service)
    {
        $this->enabled_notification_service = $service;
        $this->save();
    }



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
