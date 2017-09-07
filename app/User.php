<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->api_token = $this->randomUniqueString();
        $this->save();

        return $this->api_token;
    }

    protected function randomUniqueString()
    {
        $random = str_random(60);
        if (self::where('api_token', $random)->exists())
            $random = $this->randomUniqueString();

        return $random;
    }
}
