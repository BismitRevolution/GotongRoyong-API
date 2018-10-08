<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'fullname' ,'birthdate', 'birthplace', 'gender', 'role', 'flag_active', 'image_profile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function getRememberToken()
    {
        return $this->api_token;
    }

    public function setRememberToken($value)
    {
        $this->api_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'api_token';
    }
}
