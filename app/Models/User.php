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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'city_id',
        'council_id',
        'state_id',
          'address',
        'image_id',

    ];


    public function CarbonSubmit()
    {
        return $this->hasMany(CarbonSubmit::class, 'user_id');
    }

    public function userImage()
    {
        return $this->hasOne(Files::class, 'id', 'image_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public  function getOnlyNameAttribute()
    {
        if (!$this->name) {
            return null;
        }
        $name = explode(' ', $this->name);
        return $name[0];
    }

    public function getfirstletAttribute()
    {
        if (!$this->name) {
            return null;
        }
        //get first character of this name
        $firstlet = substr($this->name, 0, 1);
        return $firstlet;
    }

}
