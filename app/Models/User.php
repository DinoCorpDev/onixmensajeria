<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

//    protected $appends = ['city'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "lastname",
        "contact",
        "email",
        "password",
        "nickname",
        "birthday",
        "gender",
        "pyshical",
        "competences",
        "education",
        "experience",
        "identification",
        "address",
        "city",
        "profile",
        "photos",
        "video",
        "autorization",
        "terms_conditions",
        "roles",
        "status",
        "api_token",
        "provisionalPassword",
        "firstLogin",
        "verified",
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function city(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ['label' => $value, 'string' => $value]
        );
    }

    protected function country(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ['label' => $value, 'string' => $value]
        );
    }

    public function gender(){
        return $this->hasMany(Genders::class,'id','id_user');
    }

    public function contacts(){
        return $this->hasMany(Contacts::class,'id','id_user');
    }

    public function pyshical(){
        return $this->hasOne(Pyshicals::class,'id','id_user');
    }

    public function competences(){
        return $this->hasMany(Competences::class, 'id','id_user');
    }

    public function educations(){
        return $this->hasMany(Educations::class,'id','id_user');
    }

    public function experiences(){
        return $this->hasMany(Experiences::class, 'id','id_user');
    }

    public function sectors(){
        return $this->hasMany(Sectors::class, 'id','id_user');
    }

    public function roles(){
        return $this->hasMany(UsersRoles::class, 'id','id_user');
    }
}
